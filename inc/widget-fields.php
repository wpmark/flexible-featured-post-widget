<?php
/**
 * function ffpw_default_widget_options_fields()
 *
 * adds the fields for the widget editor in the admin
 */
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