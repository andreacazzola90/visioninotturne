<?php

/**
 * The admin-specific functionality of the plugin.
 *
 * @link       http://www.diviplugins.com
 * @since      3.4
 * @package    Dp_Portfolio_Posts_Pro
 * @subpackage Dp_Portfolio_Posts_Pro/admin
 * @author     DiviPlugins <support@diviplugins.com>
 */
class Dp_Portfolio_Posts_Pro_Admin {

	/**
	 * The ID of this plugin.
	 *
	 * @since 3.4
	 * @access   private
	 * @var      string $plugin_name The ID of this plugin.
	 */
	private $plugin_name;

	/**
	 * The version of this plugin.
	 *
	 * @since 3.4
	 * @access   private
	 * @var      string $version The current version of this plugin.
	 */
	private $version;

	/**
	 * Initialize the class and set its properties.
	 *
	 * @param string $plugin_name The name of this plugin.
	 * @param string $version The version of this plugin.
	 *
	 * @since 3.4
	 */
	public function __construct( $plugin_name, $version ) {
		$this->plugin_name = $plugin_name;
		$this->version     = $version;
	}

	/**
	 * Register the stylesheets for the admin area.
	 *
	 * @since 3.4
	 */
	public function enqueue_styles( $hook ) {
		if ( in_array( $hook, array( 'post.php', 'divi_page_et_theme_builder' ) ) ) {
			wp_enqueue_style( $this->plugin_name, DPPPP_URL . 'admin/css/dp-portfolio-posts-pro-admin.min.css', array(), $this->version, 'all' );
		}
	}

	/**
	 * Register the JavaScript for the admin area.
	 *
	 * @since 3.4
	 */
	public function enqueue_scripts( $hook ) {
		if ( in_array( $hook, array( 'post.php', 'divi_page_et_theme_builder' ) ) ) {
			Dp_Portfolio_Posts_Pro_Utils::enqueue_and_localize_cpt_modal_script();
		}
	}

	/**
	 * Load the template for the pop up feature.
	 *
	 * @param $string $template Default template path
	 *
	 * @return $template
	 */
	public function dp_popup_page_template( $template ) {
		if ( is_single() && isset( $_GET['dp_action'] ) && $_GET['dp_action'] == 'popup_fetch' ) {
			if ( glob( get_stylesheet_directory() . '/dp-popup-template.php' ) ) {
				$template = get_stylesheet_directory() . '/dp-popup-template.php';
			} else {
				$template = DPPPP_DIR . 'templates/dp-popup-template.php';
			}
		}

		return $template;
	}

	/**
	 *
	 * @since 4.0
	 */
	public function initialize_extension() {
		require_once DPPPP_DIR . 'includes/DpPortfolioPostsPro.php';
	}

	/**
	 * Add settings, license and get support links to the plugins lists in the plugin meta row.
	 *
	 * @since 3.4
	 */
	public function add_plugin_row_meta( $links, $file ) {
		if ( $file === plugin_basename( 'dp-portfolio-posts-pro/dp_portfolio_posts_pro.php' ) ) {
			$links['license'] = sprintf( '<a href="%s"> %s </a>', admin_url( 'plugins.php?page=dp_divi_plugins_menu' ), __( 'License', 'dpppp-dp-portfolio-posts-pro' ) );
			$links['support'] = sprintf( '<a href="%s" target="_blank"> %s </a>', 'https://diviplugins.com/documentation/portfolio-posts-pro/', __( 'Get support', 'dpppp-dp-portfolio-posts-pro' ) );
		}

		return $links;
	}

	/**
	 * Deactivate Free version
	 *
	 * @since 3.5.3
	 */
	public function admin_notice_error() {
		echo sprintf( '<div class="notice notice-info is-dismissible"><p>%1$s</p></div>', __( 'We noticed that you have DP Portfolio Posts Free version activated. We just deactivated it for you. These plugins cannot be activated at the same time.', 'dpppp-dp-portfolio-posts-pro' ) );
		deactivate_plugins( 'dp-portfolio-posts/dp-portfolio-posts.php' );
	}

}
