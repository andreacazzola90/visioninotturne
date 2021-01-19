<?php
namespace SiteGround_Optimizer\DNS;

use SiteGround_Optimizer\Helper\Helper;

/**
 *
 */
class Cloudflare {
	/**
	 * Holds the provided email address for API authentication
	 *
	 * @var string
	 */
	public $email;

	/**
	 * Holds the provided auth_key for API authentication
	 *
	 * @var string
	 */
	public $auth_key;

	/**
	 * The site url without protocol.
	 *
	 * @var string
	 */
	public $site_url;

	/**
	 * The custom worker name.
	 *
	 * @var string
	 */
	public $worker = 'sg_worker';

	/**
	 * The CloudFlare endpoint url.
	 */
	const CF_ENDPOINT = 'https://api.cloudflare.com/client/v4/';

	/**
	 * The singleton instance.
	 *
	 * @var The singleton instance.
	 */
	private static $instance;

	/**
	 * The constructor
	 *
	 * @since 5.7.0
	 */
	public function __construct() {
		// Bail if the setting is disabled.
		if ( 0 === intval( get_option( 'siteground_optimizer_cloudflare_optimization', 0 ) ) ) {
			return;
		}

		self::$instance = $this;

		add_action( 'send_headers', array( $this, 'add_headers' ), PHP_INT_MAX );
		add_action( 'template_redirect', array( $this, 'add_headers' ) );
	}

	/**
	 * Get the singleton instance.
	 *
	 * @since 5.7.0
	 *
	 * @return  The singleton instance.
	 */
	public static function get_instance() {
		if ( null == self::$instance ) {
			self::$instance = new self();
		}

		return self::$instance;
	}

	/**
	 * Create header rules after init
	 *
	 * @since  5.7.0
	 */
	public function add_headers() {
		// Change the headers if the user is logged-in or if it's an admin page.
		if (
			is_admin() ||
			\is_user_logged_in() ||
			( function_exists( 'is_cart' ) && \is_cart() ) ||
			( function_exists( 'is_checkout' ) && \is_checkout() ) ||
			( function_exists( 'edd_is_checkout' ) && \edd_is_checkout() )
		) {
			header( 'Cache-Control: no-store, no-cache, must-revalidate, max-age=0' );
			header( 'Pragma: no-cache' );
			header( 'Expires: ' . gmdate( 'D, d M Y H:i:s \G\M\T', time() ) );
			header( 'SG-Optimizer-Cache-Control: no-store, no-cache, must-revalidate, max-age=0' );
			return;
		}

		// Default headers for non-logged-in users.
		header_remove( 'Pragma' );
		header_remove( 'Expires' );
		header( 'Cache-Control: s-max-age=604800, s-maxage=604800, max-age=60' );
		header( 'SG-Optimizer-Cache-Control: s-max-age=604800, s-maxage=604800, max-age=60' );
	}

	/**
	 * Set site url
	 *
	 * @since 5.7.0
	 */
	private function prepare() {
		$this->email    = get_option( 'siteground_optimizer_cloudflare_email' );
		$this->auth_key = get_option( 'siteground_optimizer_cloudflare_auth_key' );
		$this->zone_id  = $this->set_zone_id();

		// Bail if the email or auth key are not set.
		if (
			empty( $this->auth_key ) ||
			empty( $this->email ) ||
			empty( $this->zone_id )

		) {
			return false;
		}

		return true;
	}

	/**
	 * Sets required ClooudFlare data.
	 *
	 * @since 5.7.0
	 */
	private function set_zone_id() {
		$zone_id = get_option( 'siteground_optimizer_cloudflare_zone_id', false );

		if ( false !== $zone_id ) {
			return $zone_id;
		}

		// Prepare path and data.
		$data = array(
			'name'  => preg_replace( '(^https?://(www\.)?)', '', untrailingslashit( Helper::get_site_url() ) ),
			'match' => 'all',
		);

		// Send request to API.
		$response = $this->request( 'zones', 'GET', $data );

		// Bail if no response. Return empty will cause the api to return errors.
		if ( empty( $response['result'][0]['id'] ) ) {
			return false;
		}

		update_option( 'siteground_optimizer_cloudflare_zone_id', $response['result'][0]['id'] );

		return $response['result'][0]['id'];
	}

	/**
	 * Remove the rules we've added.
	 *
	 * @since  5.7.0
	 *
	 * @return mixed      Response from the request.
	 */
	public function remove_site_rules() {
		// Get the site rules.
		$rules = $this->get_site_rules();

		foreach ( $rules as $id => $rule ) {
			$this->request(
				$this->get_path( 'identifier' ) . $id,
				'DELETE'
			);
		}
	}

	/**
	 * Get site rules.
	 *
	 * @since  5.7.0
	 *
	 * @return bool|array False on failure, page rules on success.
	 */
	public function get_site_rules() {
		// Get the site rules.
		$site_rules = $this->request(
			$this->get_path( 'list' ),
			'GET',
			array(
				'status' => 'active',
				'match'  => 'all',
			)
		);

		// Return the page rules if there are such.
		if ( empty( $site_rules['result'] ) ) {
			return false;
		}

		// Prepare the rules array.
		$rules = array();

		// Loop through all rules and collect the urls.
		foreach ( $site_rules['result'] as $rule ) {
			$rules[ $rule['id'] ] = $rule['targets'][0]['constraint']['value'];
		}

		// Return the rules.
		return $rules;
	}

	/**
	 * Add custom worker.
	 *
	 * @since 5.6.9
	 */
	public function add_worker() {
		// Bail if the email or the api key is empty.
		if ( false === $this->prepare() ) {
			wp_send_json_error( array( 'message' => 'Please provide valid APi key & email address' ) );
		}

		// Remove the existing page rules.
		$this->remove_site_rules();

		global $wp_filesystem;

		$create_worker_response = wp_remote_request(
			self::CF_ENDPOINT . $this->get_path( 'worker-id' ),
			$args = array(
				'headers' => array(
					'X-Auth-Email' => $this->email,
					'X-Auth-Key'   => $this->auth_key,
					'Content-Type' => 'application/javascript',
				),
				'body'   => $wp_filesystem->get_contents( \SiteGround_Optimizer\DIR . '/templates/cloudflare-worker.tpl' ),
				'method' => 'PUT',
			)
		);

		if ( 200 !== wp_remote_retrieve_response_code( $create_worker_response ) ) {
			return;
		}

		$response = $this->request(
			$this->get_path( 'worker' ),
			'POST',
			array(
				'pattern'                 => untrailingslashit( Helper::get_site_url() ) . '/*',
				'script'                  => $this->worker,
				'request_limit_fail_open' => true,
			)
		);

		if ( true !== $response['success'] ) {
			return;
		}

		// Keep a flag that the cloudflare optimization is successful.
		update_option( 'siteground_optimizer_cloudflare_optimization_status', 1 );

		return true;
	}

	/**
	 * Remove the worker
	 *
	 * @since  5.7.0
	 */
	public function remove_worker() {
		$this->prepare();

		$response = $this->request(
			$this->get_path( 'worker-id' ),
			'DELETE'
		);

		if ( true !== $response['success'] ) {
			return false;
		}

		return true;
	}

	/**
	 * Request to Cloudflare API.
	 *
	 * @since  5.7.0
	 *
	 * @param  string $path   Path for API Request.
	 * @param  string $method GET Method for the request.
	 * @param  array  $data   Data for API Request.
	 *
	 * @return Object.       Object response.
	 */
	public function request( $path, $method, $data = '' ) {
		// Removes null entries.
		if ( ! empty( $data ) ) {
			$data = array_filter(
				$data, function ( $val ) {
					return ! is_null( $val );
				}
			);
		}

		$args = array(
			'headers' => array(
				'X-Auth-Email' => $this->email,
				'X-Auth-Key'   => $this->auth_key,
				'Content-Type' => 'application/json',
			),
			'body' => 'GET' === $method ? $data : json_encode( $data ),
		);

		$endpoint = self::CF_ENDPOINT . $path;

		// Check which method are we using.
		switch ( $method ) {
			case 'GET':
				$response = wp_remote_get( $endpoint, $args );
				break;
			case 'POST':
				$response = wp_remote_post( $endpoint, $args );
				break;
			case 'DELETE':
				unset( $args['body'] );
				$args['method'] = 'DELETE';
				$response = wp_remote_request( $endpoint, $args );
				break;
		}

		// Get the status code of the request.
		$status_code = wp_remote_retrieve_response_code( $response );

		// Bail if request is unsuccesful.
		if ( 200 !== $status_code ) {
			return $response;
		}

		// Get the response.
		$body = wp_remote_retrieve_body( $response );

		// Return decoded json object.
		return json_decode( $body, true );
	}

	/**
	 * Create the path for the request based on the url you need for different methods.
	 *
	 * @since  5.7.0
	 *
	 * @param  string $request_type Based on links.
	 *
	 * @return string       The path.
	 */
	public function get_path( $request_type ) {
		// Check if we have valid request for path builder.
		if ( empty( $request_type ) ) {
			return false;
		}

		if ( empty( $this->zone_id ) ) {
			$this->zone_id = $this->set_zone_id();
		}

		$path = 'zones/' . $this->zone_id;

		// Create path based on method request.
		switch ( $request_type ) {
			case 'purge':
				return $path . '/purge_cache';
				break;
			case 'worker':
				return $path . '/workers/routes';
				break;
			case 'worker-id':
				return $path . '/workers/scripts/' . $this->worker;
				break;
			case 'identifier':
			case 'list':
				return $path . '/pagerules/';
				break;
		}
	}

	/**
	 * Purge all files.
	 *
	 * @since  5.7.0
	 *
	 * @return mixed Request response.
	 */
	public function purge_cache() {
		// Bail if the email or the api key is empty.
		if ( false === $this->prepare() ) {
			return;
		}

		// Make the request.
		$response = $this->request(
			$this->get_path( 'purge' ),
			'POST',
			array(
				'purge_everything' => true,
			)
		);
	}
}
