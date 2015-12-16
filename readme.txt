=== Flexible Featured Post Widget ===
Contributors: wpmarkuk
Donate link: http://markwilkinson.me/saythanks/
Tags: widget, featured posts
Requires at least: 4.3.1
Tested up to: 4.4
Stable tag: 1.0
License: GPLv2 or later
License URI: http://www.gnu.org/licenses/gpl-2.0.html

Easily add a post assigned as featured to a sidebar with flexible options.

== Description ==

This plugin allow you to mark posts (by default) as featured, using a checkbox added to the post edit screen in the Publish meta box. You can then display a random, or the latest, featured post in any sidebar using the widget. The widget provides many flexible options such as choosing whether to display the post meta, featured image and a read more link.

Through extensible features, additional widget options can be added and the widget output can easily be customised. Additional there are a number of hooks and filters in place to allow developers to extend the plugin, for example making additional post types have the ability to be featured as well as just posts.

You can read the accompanying blog about this plugin here: [http://markwilkinson.me/2015/12/flexible-featured-post-widget/](http://markwilkinson.me/2015/12/flexible-featured-post-widget/)

== Installation ==

1. Upload the plugin files to the `/wp-content/plugins/plugin-name` directory, or install the plugin through the WordPress plugins screen directly.
1. Activate the plugin through the 'Plugins' screen in WordPress
1. Click the Make Featured checkbox in a posts publish meta box
1. Add the widget to a sidebar in Appearance > Widgets

== Frequently Asked Questions ==

= Can I change the markup of the widget? =

Yes you can easily change the markup. The widgets output is actually controlled by a function hooked into the `ffpw_featured_post_output`. Therefore to add your own markup you would need to remove the action included, create your own function for the markup (use the one provided as a starting point) and then add your function to the action hook. Take a look at this example which just outputs the featured posts' title linking to the post permalink:

`
<?php
/**
 * function wpmark_remove_ffpw_output_action()
 *
 * removes the flexibile featured post widgets output
 */
function wpmark_remove_ffpw_output_action() {
	remove_action( 'ffpw_featured_post_output', 'ffpw_featured_post_output', 10, 3 );
}
add_action( 'init', 'wpmark_remove_ffpw_output_action' );

/**
 * function wpmark_add_ffpw_widget_output()
 *
 * creates the markup and output for the flexible featured post widget
 *
 * @param	array	$args is the widget args e.g. before_title / after_title
 * @param	array	$instance is the widget settings instance e.g. title, show author etc.
 * @param	obj		$post is the post object of the featured post queried
 */
function wpmark_add_ffpw_widget_output( $args, $instance, $post ) {
	
	echo $args[ 'before_widget' ];
	
	/* if we have a title */
	if( $instance[ 'title' ] != '' ) {
		echo $args[ 'before_title' ]; echo esc_html( $title ); echo $args[ 'after_title' ];
	}
	
	?>
	<h2 class="post-title">
		<a href="<?php echo esc_url( get_permalink( $post->ID ) ); ?>">
			<?php echo esc_html( $post->post_title ); ?>
		</a>
	</h2>
	<?php
	
	echo $args[ 'after_widget' ];
	
}

add_action( 'ffpw_featured_post_output', 'wpmark_add_ffpw_widget_output', 10, 3 );
?>
`

https://gist.github.com/wpmark/1f55055ec175cd74d481

= Can I add a new field into the widget editor? =

This can be done using the built in filter `ffpw_widget_options_fields`. The following code would add a new textarea for an intro paragraph:

`
<?php
function wpmark_add_ffpw_intro_field( $fields ) {
	
	$fields[ 'intro_text' ] = array(
		'id'		=> 'intro_text',
		'type'		=> 'textarea',
		'label'		=> 'Introduction Text',
		'desc'		=> 'Add some introduction text for featured posts here.'
	);
	
	return $fields;
	
}

add_filter( 'ffpw_widget_options_fields', 'wpmark_add_ffpw_intro_field', 9, 1 );
?>
`

You would have to use the action hooks in the widget output function in order to output your new field on the front-end.

== Screenshots ==

1. The widgets options.

== Changelog ==

= 0.1 =

* Initial plugin launch

== Upgrade Notice ==

Update through the WordPress admin as notified.