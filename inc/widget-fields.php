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
		'label'		=> __( 'Title', 'flexible-featured-post-widget' ),
	);
	
	$fields[ 'random_post' ] = array(
		'id'		=> 'random_post',
		'type'		=> 'checkbox',
		'label'		=> __( 'Show a random featured post? (defaults to newest)', 'flexible-featured-post-widget' ),
	);
	
	$fields[ 'show_date' ] = array(
		'id'		=> 'show_date',
		'type'		=> 'checkbox',
		'label'		=> __( 'Show post date?', 'flexible-featured-post-widget' ),
	);
	
	$fields[ 'show_author' ] = array(
		'id'		=> 'show_author',
		'type'		=> 'checkbox',
		'label'		=> __( 'Show post author?', 'flexible-featured-post-widget' ),
	);
	
	$fields[ 'show_featured_image' ] = array(
		'id'		=> 'show_featured_image',
		'type'		=> 'checkbox',
		'label'		=> __( 'Show featured image?', 'flexible-featured-post-widget' ),
		'class'		=> 'ffpw-show-featured-image',
	);
	
	$fields[ 'featured_image' ] = array(
		'id'		=> 'featured_image',
		'type'		=> 'select',
		'label'		=> __( 'Featured Image Size', 'flexible-featured-post-widget' ),
		'options'	=> ffpw_get_image_sizes_for_select(),
		'class'		=> 'ffpw-featured-image-size togglehide'
	);
	
	$fields[ 'show_readmore_link' ] = array(
		'id'		=> 'show_readmore_link',
		'type'		=> 'checkbox',
		'label'		=> __( 'Show read more link?', 'flexible-featured-post-widget' ),
		'class'		=> 'ffpw-show-readmore-link',
	);
	
	$fields[ 'readmore_text' ] = array(
		'id'		=> 'readmore_text',
		'type'		=> 'text',
		'label'		=> __( 'Read more text', 'flexible-featured-post-widget' ),
		'class'		=> 'ffpw-readmore-text togglehide',
		'desc'		=> __( 'If left blank it defaults to Read more &raquo;', 'flexible-featured-post-widget' ),
	);
	
	$fields[ 'show_excerpt' ] = array(
		'id'		=> 'show_excerpt',
		'type'		=> 'checkbox',
		'label'		=> __( 'Show Excerpt', 'flexible-featured-post-widget' ),
		'class'		=> 'ffpw-show-excerpt'
	);
	
	$fields[ 'excerpt_length' ] = array(
		'id'		=> 'excerpt_length',
		'type'		=> 'number',
		'label'		=> __( 'Excerpt Length', 'flexible-featured-post-widget' ),
		'class'		=> 'ffpw-excerpt-length togglehide',
		'desc'		=> __( 'If left blank it defaults to 50 characters.', 'flexible-featured-post-widget' ),
	);
		
	return $fields;
	
}

add_filter( 'ffpw_widget_options_fields', 'ffpw_default_widget_options_fields' );