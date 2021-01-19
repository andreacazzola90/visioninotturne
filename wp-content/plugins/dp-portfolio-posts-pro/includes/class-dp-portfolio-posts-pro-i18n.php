<?php

/**
 * Define the internationalization functionality
 *
 * Loads and defines the internationalization files for this plugin
 * so that it is ready for translation.
 *
 * @link       http://www.diviplugins.com
 * @since      3.4
 * @package    Dp_Portfolio_Posts_Pro
 * @subpackage Dp_Portfolio_Posts_Pro/includes
 * @author     DiviPlugins <support@diviplugins.com>
 */
class Dp_Portfolio_Posts_Pro_i18n {

	/**
	 * Load the plugin text domain for translation.
	 *
	 * @since    3.4
	 */
	public function load_plugin_textdomain() {
		load_plugin_textdomain( 'dpppp-dp-portfolio-posts-pro', false, 'dp-portfolio-posts-pro/languages/' );
	}

}
