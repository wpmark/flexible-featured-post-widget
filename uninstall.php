<?php
/**
 * Fired when the plugin is uninstalled.
 */
 
/* If uninstall not called from WordPress, then exit. */
if ( ! defined( 'WP_UNINSTALL_PLUGIN' ) ) {
	wp_die( sprintf( __( '%s should only be called when uninstalling the plugin.', 'wdp-plugin' ), '<code>' . __FILE__ . '</code>' ) );
}


/* Deleting FFPW widget option row in database */
delete_option('widget_FFPW_Flexible_Featured_Post');


/* Deleting post meta data added by plugin */
function delete_ffpw_meta() {
   
    global $wpdb;
    $posts = get_posts( array(
        'numberposts' => -1,
        'post_type' => 'post',
        'post_status' => 'any' ) );
    foreach ( $posts as $post ){
        delete_post_meta( $post->ID, '_ffpw_featured' );
    }
}

delete_ffpw_meta();