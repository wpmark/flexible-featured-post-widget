<?php
/**
 * function ffpw_post_types()
 *
 * determines which post type should be used to get featured posts from
 * this can be an array of post types but defaults to posts only
 */
function ffpw_post_types() {
	return apply_filters( 'ffpw_post_type', array( 'post' ) );
}

/**
 * function ffpw_widget_options_fields()
 *
 * filterable array of the fields that appear in the widget
 * form in the admin
 */
function ffpw_widget_options_fields() {
	return apply_filters( 'ffpw_widget_options_fields', array() );
}

/**
 * Get size information for all currently-registered image sizes.
 *
 * @global $_wp_additional_image_sizes
 * @uses   get_intermediate_image_sizes()
 * @return array $sizes Data for all currently-registered image sizes.
 */
function ffpw_get_image_sizes() {
	
	global $_wp_additional_image_sizes;

	$sizes = array();

	foreach( get_intermediate_image_sizes() as $_size ) {
		
		if( in_array( $_size, array( 'thumbnail', 'medium', 'large' ) ) ) {
			
			$sizes[ $_size ]['width']  = get_option( "{$_size}_size_w" );
			$sizes[ $_size ]['height'] = get_option( "{$_size}_size_h" );
			$sizes[ $_size ]['crop']   = (bool) get_option( "{$_size}_crop" );
			
		} elseif( isset( $_wp_additional_image_sizes[ $_size ] ) ) {
			
			$sizes[ $_size ] = array(
				'width'  => $_wp_additional_image_sizes[ $_size ]['width'],
				'height' => $_wp_additional_image_sizes[ $_size ]['height'],
				'crop'   => $_wp_additional_image_sizes[ $_size ]['crop'],
			);
			
		}
	}

	return $sizes;
	
}

/**
 * function ffpw_get_image_sizes_for_select()
 *
 * gets an array of image sizes suitable for a select loop
 */
function ffpw_get_image_sizes_for_select() {
	
	$select_sizes = array();
	
	/* get the image sizes */
	$sizes = ffpw_get_image_sizes();
	
	/* loop through each size */
	foreach( $sizes as $size_name => $size_info ) {
		
		/* add this size to our select size array */
		$select_sizes[ $size_name ] = ucfirst( $size_name ) . ' (' . $size_info[ 'width' ] . ' x ' . $size_info[ 'height' ] . ')';
		
	}
	
	return $select_sizes;
	
}