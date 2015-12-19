<?php
/*
Plugin Name: Flexible Featured Post Widget
Plugin URI: https://github.com/wpmark/flexible-featured-posts-widget
Description: This plugin provides a sidebar widget to display posts marked as featured in the post edit screen. It provides customisible options for what to display.
Author: Mark Wilkinson
Author URI: http://markwilkinson.me
Version: 1.0.1
Text Domain: flexible-featured-post-widget
Domain Path: /languages/

This program is free software; you can redistribute it and/or modify
it under the terms of the GNU General Public License as published by
the Free Software Foundation; either version 2 of the License, or
(at your option) any later version.

This program is distributed in the hope that it will be useful,
but WITHOUT ANY WARRANTY; without even the implied warranty of
MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
GNU General Public License for more details.

*/

/* exit if directly accessed */
if( ! defined( 'ABSPATH' ) ) exit;

/* define variable for path to this plugin file. */
define( 'FFPW_LOCATION', dirname( __FILE__ ) );
define( 'FFPW_LOCATION_URL', plugins_url( '', __FILE__ ) );

/**
 * include the necessary admin includes files for the plugin
 */
require_once dirname( __FILE__ ) . '/admin/admin.php';

/**
 * include the necessary includes files for the plugin
 */
require_once dirname( __FILE__ ) . '/inc/ffpw-functions.php';
require_once dirname( __FILE__ ) . '/inc/widget-fields.php';
require_once dirname( __FILE__ ) . '/inc/widget.php';
require_once dirname( __FILE__ ) . '/inc/widget-output.php';

/**
 * function ffpw_enqueue_admin_scripts()
 */
function ffpw_enqueue_admin_scripts( $hook ) {
	
	/* build page array where to enqueue scripts on */
	$pages = array( 'widgets.php', 'customizer.php' );
	
	/* if we are not on the widgets or in the customizer */
	if( ! in_array( $hook, $pages ) ) {
		return;
    }
	
	/* enqueue the plugin js */
	wp_enqueue_script( 'ffpw_js', plugins_url( 'assets/ffpw.js', __FILE__ ), 'jquery' );
	
}

add_action( 'admin_enqueue_scripts', 'ffpw_enqueue_admin_scripts' );

/**
 * function ffpw_enqueue_frontend_scripts()
 *
 * enqueue any frontend scripts that are needed including css stylesheets
 */
function ffpw_enqueue_frontend_scripts() {
	
	/* enqueue the stylesheet :-( */
	wp_enqueue_style( 'ffpw_style', plugins_url( 'assets/ffpw.css', __FILE__ ) );
	
}

add_action( 'wp_enqueue_scripts', 'ffpw_enqueue_frontend_scripts' );