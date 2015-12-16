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
 *
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

function ffpw_default_widget_options_fields( $fields ) {
	
	$fields[ 'title' ] = array(
		'id'		=> 'title',
		'type'		=> 'text',
		'label'		=> 'Title',
	);
	
	$fields[ 'random_post' ] = array(
		'id'		=> 'random_post',
		'type'		=> 'checkbox',
		'label'		=> 'Show a random featured post? (defaults to newest)',
	);
	
	$fields[ 'show_date' ] = array(
		'id'		=> 'show_date',
		'type'		=> 'checkbox',
		'label'		=> 'Show post date?',
	);
	
	$fields[ 'show_author' ] = array(
		'id'		=> 'show_author',
		'type'		=> 'checkbox',
		'label'		=> 'Show post author?',
	);
	
	$fields[ 'show_featured_image' ] = array(
		'id'		=> 'show_featured_image',
		'type'		=> 'checkbox',
		'label'		=> 'Show featured image?',
		'class'		=> 'ffpw-show-featured-image',
	);
	
	$fields[ 'featured_image' ] = array(
		'id'		=> 'featured_image',
		'type'		=> 'select',
		'label'		=> 'Featured Image Size',
		'options'	=> ffpw_get_image_sizes_for_select(),
		'class'		=> 'ffpw-featured-image-size togglehide'
	);
	
	$fields[ 'show_readmore_link' ] = array(
		'id'		=> 'show_readmore_link',
		'type'		=> 'checkbox',
		'label'		=> 'Show read more link?',
		'class'		=> 'ffpw-show-readmore-link',
	);
	
	$fields[ 'readmore_text' ] = array(
		'id'		=> 'readmore_text',
		'type'		=> 'text',
		'label'		=> 'Read more text',
		'class'		=> 'ffpw-readmore-text togglehide',
		'desc'		=> 'If left blank it defaults to Read more &raquo;'
	);
	
	$fields[ 'show_excerpt' ] = array(
		'id'		=> 'show_excerpt',
		'type'		=> 'checkbox',
		'label'		=> 'Show Excerpt',
		'class'		=> 'ffpw-show-excerpt'
	);
	
	$fields[ 'excerpt_length' ] = array(
		'id'		=> 'excerpt_length',
		'type'		=> 'number',
		'label'		=> 'Excerpt Length',
		'class'		=> 'ffpw-excerpt-length togglehide',
		'desc'		=> 'If left blank it defaults to 50 characters.'
	);
		
	return $fields;
	
}

add_filter( 'ffpw_widget_options_fields', 'ffpw_default_widget_options_fields' );