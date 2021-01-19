<?php

/**
 * License related functions
 *
 * @link       http://www.diviplugins.com
 * @since      4.0
 * @package    Dp_Portfolio_Posts_Pro
 * @subpackage Dp_Portfolio_Posts_Pro/includes
 * @author     DiviPlugins <support@diviplugins.com>
 */
class Dp_Portfolio_Posts_Pro_License {

	/**
	 * Init plugin updater class to receive automatic updates
	 *
	 * @since 3.4
	 */
	public function init_plugin_updater() {
		// To support auto-updates, this needs to run during the wp_version_check cron job for privileged users.
		$doing_cron = defined( 'DOING_CRON' ) && DOING_CRON;
		if ( ! current_user_can( 'manage_options' ) && ! $doing_cron ) {
			return;
		}
		$license_key = trim( get_option( 'dp_ppp_license_key' ) );
		new DP_Portfolio_Posts_Pro_Updater( DPPPP_STORE_URL, DPPPP_DIR . 'dp_portfolio_posts_pro.php', array(
				'version'   => DPPPP_VERSION,
				'license'   => $license_key,
				'item_id'   => DPPPP_ITEM_ID,
				'item_name' => DPPPP_ITEM_NAME,
				'author'    => 'Divi Plugins',
				'beta'      => false
			)
		);
	}

	/**
	 * License page html
	 *
	 * @since 3.4
	 */
	public function license_html() {
		$license = get_option( 'dp_ppp_license_key' );
		$status  = get_option( 'dp_ppp_license_status' );
		echo sprintf( '<div class="dp-license-block"><h2>%1$s</h2>', __( 'Portfolio Posts Pro License', 'dpppp-dp-portfolio-posts-pro' ) );
		echo '<form method="post" action="options.php">';
		settings_fields( 'dp_ppp_license' );
		echo sprintf( '<table class="form-table"><tbody><tr><th scope="row">%1$s</th>', __( 'License Key', 'dpppp-dp-portfolio-posts-pro' ) );
		echo sprintf( '<td><input id="dp_ppp_license_key" name="dp_ppp_license_key" type="password" class="regular-text" placeholder="%2$s" value="%1$s" /><label class="description" for="dp_ppp_license_key"></label></td></tr>', esc_attr__( $license ), __( 'Enter your license key', 'dpppp-dp-portfolio-posts-pro' ) );
		echo sprintf( '<tr><th scope="row">%1$s</th><td>', __( 'License Status', 'dpppp-dp-portfolio-posts-pro' ) );
		if ( $status == 'valid' ) {
			echo sprintf( '<span class="active">%1$s</span>', __( 'Active', 'dpppp-dp-portfolio-posts-pro' ) );
			wp_nonce_field( 'dp_ppp_license_nonce', 'dp_ppp_license_nonce' );
			echo sprintf( '<input type="submit" class="button-secondary" name="dp_ppp_license_deactivate" value="%1$s"/>', __( 'Deactivate License', 'dpppp-dp-portfolio-posts-pro' ) );
		} else {
			echo sprintf( '<span class="inactive">%1$s</span>', __( 'Inactive', 'dpppp-dp-portfolio-posts-pro' ) );
			wp_nonce_field( 'dp_ppp_license_nonce', 'dp_ppp_license_nonce' );
			echo sprintf( '<input type="submit" class="button-secondary" name="dp_ppp_license_activate" value="%1$s"/>', __( 'Activate License', 'dpppp-dp-portfolio-posts-pro' ) );
		}
		echo '</td></tr>';
		echo '</tbody></table></form></div>';
	}

	/**
	 * Register license option
	 *
	 * @since 3.4
	 */
	public function register_license_option() {
		register_setting( 'dp_ppp_license', 'dp_ppp_license_key', array(
			$this,
			'sanitize_license'
		) );
	}

	/**
	 * Sanitize license
	 *
	 * @since 3.4
	 */
	public function sanitize_license( $new ) {
		$old = get_option( 'dp_ppp_license_key' );
		if ( $old && $old != $new ) {
			delete_option( 'dp_ppp_license_status' );
		}

		return $new;
	}

	/**
	 * Activate license
	 *
	 * @since 3.4
	 */
	public function activate_license() {
		if ( isset( $_POST['dp_ppp_license_activate'] ) ) {
			if ( ! check_admin_referer( 'dp_ppp_license_nonce', 'dp_ppp_license_nonce' ) ) {
				return;
			}
			if ( $_POST['dp_ppp_license_key'] !== get_option( 'dp_ppp_license_key' ) ) {
				update_option( 'dp_ppp_license_key', $_POST['dp_ppp_license_key'] );
				$license = trim( $_POST['dp_ppp_license_key'] );
			} else {
				$license = trim( get_option( 'dp_ppp_license_key' ) );
			}
			$api_params = array(
				'edd_action' => 'activate_license',
				'license'    => $license,
				'item_name'  => urlencode( DPPPP_ITEM_NAME ),
				'url'        => home_url()
			);
			$response   = wp_remote_post( DPPPP_STORE_URL, array(
				'timeout'   => 15,
				'sslverify' => false,
				'body'      => $api_params
			) );
			if ( is_wp_error( $response ) || 200 !== wp_remote_retrieve_response_code( $response ) ) {

				if ( is_wp_error( $response ) ) {
					$message = $response->get_error_message();
				} else {
					$message = __( 'An error occurred on the license server, please try again.', 'dpppp-dp-portfolio-posts-pro' );
				}
			} else {
				$license_data = json_decode( wp_remote_retrieve_body( $response ) );
				if ( false === $license_data->success ) {
					switch ( $license_data->error ) {
						case 'expired' :
							$message = sprintf( __( 'Your license key expired on %s.', 'dpppp-dp-portfolio-posts-pro' ), date_i18n( get_option( 'date_format' ), strtotime( $license_data->expires, current_time( 'timestamp' ) ) ) );
							break;
						case 'revoked' :
							$message = __( 'Your license key has been disabled.', 'dpppp-dp-portfolio-posts-pro' );
							break;
						case 'missing' :
							$message = __( 'Invalid license.', 'dpppp-dp-portfolio-posts-pro' );
							break;
						case 'invalid' :
						case 'site_inactive' :
							$message = __( 'Your license is not active for this URL.', 'dpppp-dp-portfolio-posts-pro' );
							break;
						case 'item_name_mismatch' :
							$message = sprintf( __( 'This appears to be an invalid license key for %s.', 'dpppp-dp-portfolio-posts-pro' ), DPPPP_ITEM_NAME );
							break;
						case 'no_activations_left':
							$message = __( 'Your license key has reached its activation limit.', 'dpppp-dp-portfolio-posts-pro' );
							break;
						default :
							$message = __( 'An error occurred with the license data, please try again.', 'dpppp-dp-portfolio-posts-pro' );
							break;
					}
				}
			}
			if ( ! empty( $message ) ) {
				$base_url = admin_url( 'plugins.php?page=dp_divi_plugins_menu&product=DPPPP' );
				$redirect = add_query_arg( array(
					'sl_activation' => 'false',
					'message'       => urlencode( $message )
				), $base_url );
				wp_redirect( $redirect );
				exit();
			}
			update_option( 'dp_ppp_license_status', $license_data->license );
			wp_redirect( admin_url( 'plugins.php?page=dp_divi_plugins_menu&sl_activation=true&message=OK&product=DPPPP' ) );
			exit();
		}
	}

	/**
	 * Deactivate license
	 *
	 * @since 3.4
	 */
	public function deactivate_license() {
		if ( isset( $_POST['dp_ppp_license_deactivate'] ) ) {
			if ( ! check_admin_referer( 'dp_ppp_license_nonce', 'dp_ppp_license_nonce' ) ) {
				return;
			}
			$license    = trim( get_option( 'dp_ppp_license_key' ) );
			$api_params = array(
				'edd_action' => 'deactivate_license',
				'license'    => $license,
				'item_name'  => urlencode( DPPPP_ITEM_NAME ),
				'url'        => home_url()
			);
			$response   = wp_remote_post( DPPPP_STORE_URL, array(
				'timeout'   => 15,
				'sslverify' => false,
				'body'      => $api_params
			) );
			if ( is_wp_error( $response ) || 200 !== wp_remote_retrieve_response_code( $response ) ) {
				if ( is_wp_error( $response ) ) {
					$message = $response->get_error_message();
				} else {
					$message = __( 'An error occurred, please try again.' );
				}
				$base_url = admin_url( 'plugins.php?page=dp_divi_plugins_menu&product=DPPPP' );
				$redirect = add_query_arg( array(
					'sl_activation' => 'false',
					'message'       => urlencode( $message )
				), $base_url );
				wp_redirect( $redirect );
				exit();
			}
			delete_option( 'dp_ppp_license_status' );
			wp_redirect( admin_url( 'plugins.php?page=dp_divi_plugins_menu' ) );
			exit();
		}
	}

	/**
	 * Admin notice with the result of the activation action
	 *
	 * @since 3.4
	 */
	public function admin_notice_license_result() {
		if ( isset( $_GET['sl_activation'] ) && ! empty( $_GET['message'] ) && $_GET['page'] === 'dp_divi_plugins_menu' && $_GET['product'] === 'DPPPP' ) {
			if ( $_GET['sl_activation'] === 'false' ) {
				$message = urldecode( $_GET['message'] );
				echo sprintf( '<div class="notice notice-error is-dismissible"><p>%1$s</p></div>', $message );
			} else {
				echo sprintf( '<div class="notice notice-success is-dismissible"><p>%1$s</p></div>', __( 'Thank you for purchasing and activating DP Portfolio Posts Pro.', 'dpppp-dp-portfolio-posts-pro' ) );
			}
		}
	}

	/**
	 * Admin notice asking for activation
	 *
	 * @since 3.4
	 */
	public function admin_notice_license_activation() {
		echo sprintf( '<div class="notice notice-info is-dismissible"><p>%1$s <a href="plugins.php?page=dp_divi_plugins_menu">%2$s</a></p></div>', __( 'Please activate your Portfolio Posts Pro Pro license to receive support and automatic updates.', 'dpppp-dp-portfolio-posts-pro' ), __( 'Activation Page', 'dpppp-dp-portfolio-posts-pro' ) );
	}

}
