<?php

/**
 * The public-facing functionality of the plugin.
 *
 * Defines the plugin name, version, and two examples hooks for how to
 * enqueue the public-facing stylesheet and JavaScript.
 *
 * @link       http://www.diviplugins.com
 * @since      3.4
 * @package    Dp_Portfolio_Posts_Pro
 * @subpackage Dp_Portfolio_Posts_Pro/public
 * @author     DiviPlugins <support@diviplugins.com>
 */
class Dp_Portfolio_Posts_Pro_Public {

	/**
	 * The ID of this plugin.
	 *
	 * @since    3.4
	 * @access   private
	 * @var      string $plugin_name The ID of this plugin.
	 */
	private $plugin_name;

	/**
	 * The version of this plugin.
	 *
	 * @since    3.4
	 * @access   private
	 * @var      string $version The current version of this plugin.
	 */
	private $version;

	/**
	 * Initialize the class and set its properties.
	 *
	 * @param string $plugin_name The name of the plugin.
	 * @param string $version The version of this plugin.
	 *
	 * @since    3.4
	 */
	public function __construct( $plugin_name, $version ) {
		$this->plugin_name = $plugin_name;
		$this->version     = $version;
	}

	/**
	 * Register the JavaScript for the public-facing side of the site.
	 *
	 * @since    3.4
	 */
	public function enqueue_scripts() {
		if ( function_exists( 'et_core_is_fb_enabled' ) && et_core_is_fb_enabled() && ! wp_script_is( 'dp-portfolio-posts-pro-admin-cpt-modal' ) ) {
			Dp_Portfolio_Posts_Pro_Utils::enqueue_and_localize_cpt_modal_script();
		}
	}

}
