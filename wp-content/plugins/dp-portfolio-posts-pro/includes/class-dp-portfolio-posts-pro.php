<?php

/**
 * The file that defines the core plugin class
 *
 * A class definition that includes attributes and functions used across both the
 * public-facing side of the site and the admin area.
 *
 * @link       http://www.diviplugins.com
 * @since      3.4
 * @package    Dp_Portfolio_Posts_Pro
 * @subpackage Dp_Portfolio_Posts_Pro/includes
 * @author     DiviPlugins <support@diviplugins.com>
 */
class Dp_Portfolio_Posts_Pro {

	/**
	 * The loader that's responsible for maintaining and registering all hooks that power
	 * the plugin.
	 *
	 * @since 3.4
	 * @access   protected
	 * @var      Dp_Portfolio_Posts_Pro_Loader $loader Maintains and registers all hooks for the plugin.
	 */
	protected $loader;

	/**
	 * The unique identifier of this plugin.
	 *
	 * @since 3.4
	 * @access   protected
	 * @var      string $plugin_name The string used to uniquely identify this plugin.
	 */
	protected $plugin_name;

	/**
	 * The current version of the plugin.
	 *
	 * @since 3.4
	 * @access   protected
	 * @var      string $version The current version of the plugin.
	 */
	protected $version;

	/**
	 * Define the core functionality of the plugin.
	 *
	 * Set the plugin name and the plugin version that can be used throughout the plugin.
	 * Load the dependencies, define the locale, and set the hooks for the admin area and
	 * the public-facing side of the site.
	 *
	 * @since 3.4
	 */
	public function __construct() {
		if ( defined( 'DPPPP_VERSION' ) ) {
			$this->version = DPPPP_VERSION;
		} else {
			$this->version = '1.0.0';
		}
		$this->plugin_name = 'dpppp-dp-portfolio-posts-pro';
		$this->load_dependencies();
		$this->set_locale();
		$this->define_admin_hooks();
		$this->define_public_hooks();
	}

	/**
	 * Load the required dependencies for this plugin.
	 *
	 * Include the following files that make up the plugin:
	 *
	 * - Dp_Portfolio_Posts_Pro_Loader. Orchestrates the hooks of the plugin.
	 * - Dp_Portfolio_Posts_Pro_i18n. Defines internationalization functionality.
	 * - Dp_Portfolio_Posts_Pro_Admin. Defines all hooks for the admin area.
	 * - Dp_Portfolio_Posts_Pro_Public. Defines all hooks for the public side of the site.
	 *
	 * Create an instance of the loader which will be used to register the hooks
	 * with WordPress.
	 *
	 * @since 3.4
	 * @access   private
	 */
	private function load_dependencies() {
		require_once DPPPP_DIR . 'includes/class-dp-portfolio-posts-pro-loader.php';
		require_once DPPPP_DIR . 'includes/class-dp-page.php';
		require_once DPPPP_DIR . 'includes/class-dp-portfolio-posts-pro-updater.php';
		require_once DPPPP_DIR . 'includes/class-dp-portfolio-posts-pro-utils.php';
		require_once DPPPP_DIR . 'includes/class-dp-portfolio-posts-pro-i18n.php';
		require_once DPPPP_DIR . 'includes/class-dp-portfolio-posts-pro-license.php';
		require_once DPPPP_DIR . 'admin/class-dp-portfolio-posts-pro-admin.php';
		require_once DPPPP_DIR . 'public/class-dp-portfolio-posts-pro-public.php';
		$this->loader = new Dp_Portfolio_Posts_Pro_Loader();
	}

	/**
	 * Define the locale for this plugin for internationalization.
	 *
	 * Uses the Dp_Portfolio_Posts_Pro_i18n class in order to set the domain and to register the hook
	 * with WordPress.
	 *
	 * @since 3.4
	 * @access   private
	 */
	private function set_locale() {
		$plugin_i18n = new Dp_Portfolio_Posts_Pro_i18n();
		$this->loader->add_action( 'plugins_loaded', $plugin_i18n, 'load_plugin_textdomain' );
	}

	/**
	 * Register all of the hooks related to the admin area functionality
	 * of the plugin.
	 *
	 * @since 3.4
	 * @access   private
	 */
	private function define_admin_hooks() {
		$dp_page = new DiviPlugins_Menu_Page();
		$this->loader->add_action( 'admin_menu', $dp_page, 'add_dp_page' );
		$plugin_admin = new Dp_Portfolio_Posts_Pro_Admin( $this->get_plugin_name(), $this->get_version() );
		$this->loader->add_action( 'divi_extensions_init', $plugin_admin, 'initialize_extension' );
		$this->loader->add_action( 'admin_enqueue_scripts', $plugin_admin, 'enqueue_styles' );
		$this->loader->add_action( 'admin_enqueue_scripts', $plugin_admin, 'enqueue_scripts' );
		include_once( ABSPATH . 'wp-admin/includes/plugin.php' );
		if ( is_plugin_active( 'dp-portfolio-posts/dp-portfolio-posts.php' ) ) {
			$this->loader->add_action( 'admin_notices', $plugin_admin, 'admin_notice_error' );
		}
		/*
		 * License activation hooks related
		 */
		$license = new Dp_Portfolio_Posts_Pro_License();
		$this->loader->add_action( 'init', $license, 'init_plugin_updater', 0 );
		$this->loader->add_action( 'diviplugins_page_add_license', $license, 'license_html' );
		$this->loader->add_action( 'admin_init', $license, 'register_license_option' );
		$this->loader->add_action( 'admin_init', $license, 'activate_license' );
		$this->loader->add_action( 'admin_init', $license, 'deactivate_license' );
		$this->loader->add_action( 'admin_notices', $license, 'admin_notice_license_result' );
		if ( get_option( 'dp_ppp_license_status' ) !== 'valid' ) {
			$this->loader->add_action( 'admin_notices', $license, 'admin_notice_license_activation' );
		}
		/*
		 * Posts types and taxonomies related hooks
		 */
		$plugin_util = new Dp_Portfolio_Posts_Pro_Utils();
		$this->loader->add_action( 'wp_ajax_dpppp_get_cpt_action', $plugin_util, 'ajax_get_cpt' );
		$this->loader->add_action( 'wp_ajax_dpppp_get_taxonomies_action', $plugin_util, 'ajax_get_taxonomies' );
		$this->loader->add_action( 'wp_ajax_dpppp_get_taxonomies_terms_action', $plugin_util, 'ajax_get_taxonomies_terms' );
		/*
		 * Popup related hooks
		 */
		$this->loader->add_filter( 'template_include', $plugin_admin, 'dp_popup_page_template', 99 );
		/*
		 * Others
		 */
		$this->loader->add_filter( 'plugin_row_meta', $plugin_admin, 'add_plugin_row_meta', 10, 2 );
		/*
		 * VB
		 */
		$this->loader->add_action( 'wp_ajax_dpppp_get_posts_data_action', $plugin_util, 'ajax_get_posts_data' );
		/*
		 * Use et functions on Visual Builder
		 */
		$this->loader->add_filter( 'et_builder_load_actions', $plugin_util, 'add_our_custom_action' );
	}

	/**
	 * The name of the plugin used to uniquely identify it within the context of
	 * WordPress and to define internationalization functionality.
	 *
	 * @return    string    The name of the plugin.
	 * @since     3.4
	 */
	public function get_plugin_name() {
		return $this->plugin_name;
	}

	/**
	 * Retrieve the version number of the plugin.
	 *
	 * @return    string    The version number of the plugin.
	 * @since     3.4
	 */
	public function get_version() {
		return $this->version;
	}

	/**
	 * Register all of the hooks related to the public-facing functionality
	 * of the plugin.
	 *
	 * @since 3.4
	 * @access   private
	 */
	private function define_public_hooks() {
		$plugin_public = new Dp_Portfolio_Posts_Pro_Public( $this->get_plugin_name(), $this->get_version() );
		$this->loader->add_action( 'wp_enqueue_scripts', $plugin_public, 'enqueue_scripts' );
	}

	/**
	 * Run the loader to execute all of the hooks with WordPress.
	 *
	 * @since 3.4
	 */
	public function run() {
		$this->loader->run();
	}

	/**
	 * The reference to the class that orchestrates the hooks with the plugin.
	 *
	 * @return    Dp_Portfolio_Posts_Pro_Loader    Orchestrates the hooks of the plugin.
	 * @since     3.4
	 */
	public function get_loader() {
		return $this->loader;
	}

}
