<?php
/**
 * function ffpw_featured_post_output()
 *
 * provides the output for the widget
 */
function ffpw_featured_post_output( $args, $instance, $post ) {
	
	/* do we have a widget title */
	if( $instance[ 'title' ] != '' ) {
		
		/* output title with before and after title content */
		echo $args[ 'before_title' ]; echo esc_html( $instance[ 'title' ] ); echo $args[ 'after_title' ];
		
	}
	
	/* get the post class */
	$post_class = get_post_class( $post->ID );
	
	/* remove the post id from the array */
	$post_id = array_shift( $post_class );
	
	/**
	 * @hook - ffpw_before_featured_post_output
	 *
	 * @param $args		array	the current widget args
	 * @param $instance	array	the current widget instance
	 * @param $post		mixed	the queried featured post
	 */
	do_action( 'ffpw_before_featured_post_output', $args, $instance, $post );
	
	?>
	
	<article class="<?php echo esc_attr( str_replace( ',', ' ', implode( ',', $post_class ) ) ); ?>">
		
		<?php
			
			/**
			 * @hook - ffpw_before_featured_post
			 *
			 * @param $args		array	the current widget args
			 * @param $instance	array	the current widget instance
			 * @param $post		mixed	the queried featured post
			 */
			do_action( 'ffpw_before_featured_post', $args, $instance, $post );	
			
		?>
		
		<h3 class="entry-title">
			<a href="<?php echo esc_url( get_permalink( $post->ID ) ); ?>"><?php echo esc_html( $post->post_title ); ?></a>
		</h3>
		
		<?php
			
			/**
			 * @hook - ffpw_before_featured_post
			 *
			 * @param $args		array	the current widget args
			 * @param $instance	array	the current widget instance
			 * @param $post		mixed	the queried featured post
			 */
			do_action( 'ffpw_after_featured_post_title', $args, $instance, $post );
			
			/* store the post meta data in here */
			$post_meta = array();
			
			/* are we showing the date */
			if( $instance[ 'show_date' ] != '' ) {
				
				/* add the date to the post meta array */
				$post_meta[ 'post_date' ] = array(
					'class'		=> 'post-date',
					'value'		=> get_the_time( get_option( 'date_format' ), $post ),
					'container'	=> 'div',
					'label'		=> ''
				);
				
			}
			
			/* are we showing the date */
			if( $instance[ 'show_author' ] != '' ) {
				
				/* add the date to the post meta array */
				$post_meta[ 'show_author' ] = array(
					'class'		=> 'author',
					'label'		=> __( 'By', 'flexible-featured-post-widget' ),
					'value'		=> get_the_author_meta( 'display_name', $post->post_author ),
					'container'	=> 'div'
				);
				
			}
			
			/* check we have post meta to output */
			if( ! empty( $post_meta ) ) {
				
				?>
				
				<div class="post-meta">
					
					<?php
						
						/* loop through each meta item */
						foreach( apply_filters( 'ffpw_featured_post_meta_args', $post_meta ) as $meta ) {
							
							?>
							
							<<?php echo esc_html( $meta[ 'container' ] ); ?> class="meta-item<?php echo esc_attr( ' ' . $meta[ 'class' ] ); ?>">
								<span class="meta-label"><?php echo esc_html( $meta[ 'label' ] ); ?></span> <span class="meta-value"><?php echo esc_html( $meta[ 'value' ] ); ?></span>
							</<?php echo esc_html( $meta[ 'container' ] ); ?>>
							
							<?php
							
						}
						
					?>
					
				</div><!-- // post-meta -->
				
				<?php
				
				/**
				 * @hook - ffpw_after_featured_post_meta
				 *
				 * @param $args		array	the current widget args
				 * @param $instance	array	the current widget instance
				 * @param $post		mixed	the queried featured post
				 */
				do_action( 'ffpw_after_featured_post_meta', $args, $instance, $post );
				
			}
			
			/* are we displaying a featured image */
			if( $instance[ 'show_featured_image' ] == 1 ) {
				
				/* get the featured image size */
				$size = $instance[ 'featured_image' ];
				
				/* if no image size is set */
				if( $size == '0' ) {
					
					/* default to thumbnail */
					$size = 'thumbnail';
					
				}
				
				?>

				<div class="post-image">
					
					<a href="<?php echo esc_url( get_permalink( $post->ID ) ); ?>">
						<?php the_post_thumbnail( $size ); ?>
					</a>
					
				</div>
				
				<?php
				
				/**
				 * @hook - ffpw_after_featured_post_image
				 *
				 * @param $args		array	the current widget args
				 * @param $instance	array	the current widget instance
				 * @param $post		mixed	the queried featured post
				 */
				do_action( 'ffpw_after_featured_post_image', $args, $instance, $post );
				
			} // end if show image
			
			/* are we displaying the excerpt */
			if( $instance[ 'show_excerpt' ] == 1 ) {
				
				/* what excerpt length */
				$excerpt_length = $instance[ 'excerpt_length' ];
				
				/* if no excerpt length provided */
				if( $instance[ 'excerpt_length' ] == '' ) {
					
					/* set to default of 50 */
					$instance[ 'excerpt_length' ] = 50;
					
				}
				
				?>
				
				<div class="post-excerpt">
					<?php echo wp_trim_words(  get_the_excerpt(), (int) $instance[ 'excerpt_length' ], '...' ); ?>
				</div><!-- // post-excerpt -->
				
				<?php
				
				/**
				 * @hook - ffpw_after_featured_post_excerpt
				 *
				 * @param $args		array	the current widget args
				 * @param $instance	array	the current widget instance
				 * @param $post		mixed	the queried featured post
				 */
				do_action( 'ffpw_after_featured_post_excerpt', $args, $instance, $post );
				
			} // end if show excerpt
			
			/* are we displaying the read more link */
			if( $instance[ 'show_readmore_link' ] == 1 ) {
								
				/* if we have no read more text set */
				if( $instance[ 'readmore_text' ] == '' ) {
					
					/* use default read more text */
					$instance[ 'readmore_text' ] = __( 'Read more &raquo;', 'flexible-featured-post-widget' );
					
				}
				
				?>
				<p class="readmore"><a href="<?php echo esc_url( get_permalink( $post->ID ) ); ?>"><?php echo esc_html( $instance[ 'readmore_text' ] ); ?></a></p>
				<?php
				
				/**
				 * @hook - ffpw_after_featured_post_readmore
				 *
				 * @param $args		array	the current widget args
				 * @param $instance	array	the current widget instance
				 * @param $post		mixed	the queried featured post
				 */
				do_action( 'ffpw_after_featured_post_readmore', $args, $instance, $post );
				
			}
			
		?>
		
	</article><!-- // post-class -->
	
	<?php
	
}

add_action( 'ffpw_featured_post_output', 'ffpw_featured_post_output', 10, 3 );