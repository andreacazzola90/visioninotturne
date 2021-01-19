<?php

/*
  Plugin Name: DP Portfolio Posts Pro
  Plugin URI: http://www.diviplugins.com/divi/portfolio-posts-pro-plugin/
  Description: Creates three new modules similar to Divi's portfolio modules, but with the ability to load posts or any custom post type. Also adds new features: open posts in a popup window, open the featured image in a lightbox, display custom fields.
  Version: 4.1.1
  Author: DiviPlugins
  Author URI: http://www.diviplugins.com
  License: GPL2
  License URI: https://www.gnu.org/licenses/gpl-2.0.html
  Text Domain: dpppp-dp-portfolio-posts-pro
  Domain Path: /languages

  Dp Portfolio Posts Pro is free software: you can redistribute it and/or modify
  it under the terms of the GNU General Public License as published by
  the Free Software Foundation, either version 2 of the License, or
  any later version.

  Dp Portfolio Posts Pro is distributed in the hope that it will be useful,
  but WITHOUT ANY WARRANTY; without even the implied warranty of
  MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE. See the
  GNU General Public License for more details.

  You should have received a copy of the GNU General Public License
  along with Dp Portfolio Posts Pro. If not, see https://www.gnu.org/licenses/gpl-2.0.html.
 */
// If this file is called directly, abort.
if ( ! defined( 'WPINC' ) ) {
	die;
}

define( 'DPPPP_VERSION', '4.1.1' );
define( 'DPPPP_DIR', plugin_dir_path( __FILE__ ) );
define( 'DPPPP_URL', plugin_dir_url( __FILE__ ) );
define( 'DPPPP_STORE_URL', 'https://diviplugins.com/' );
define( 'DPPPP_ITEM_NAME', 'Portfolio Posts Pro' );
define( 'DPPPP_ITEM_ID', '4548' );

/**
 * The core plugin class that is used to define internationalization,
 * admin-specific hooks, and public-facing site hooks.
 */
require DPPPP_DIR . 'includes/class-dp-portfolio-posts-pro.php';

/**
 * Begins execution of the plugin.
 *
 * Since everything within the plugin is registered via hooks,
 * then kicking off the plugin from this point in the file does
 * not affect the page life cycle.
 *
 * @since 3.4
 */
if ( ! function_exists( 'run_dp_portfolio_posts_pro' ) ) {
	function run_dp_portfolio_posts_pro() {
		$plugin = new Dp_Portfolio_Posts_Pro();
		$plugin->run();
	}

	run_dp_portfolio_posts_pro();
}
