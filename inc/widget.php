<?php
/**
 * class FFPW_Flexible_Featured_Post
 *
 * extends the widget class to build the new widget
 */
class FFPW_Flexible_Featured_Post extends WP_Widget {
	
	/**
	* sets up the widget settings
	* description and classesname for example
	*/
	function ffpw_flexible_featured_post() {
	
		$this->WP_Widget(
			'ffpw_flexible_featured_post',
			__( 'Flexible Featured Post Widget', 'flexible-featured-post-widget' ),
			array(
				'classname' => 'ffpw-widget',
				'description' => __( 'Show a featured post in a sidebar.', 'flexible-featured-post-widget' )
			)
		);
	
	}
	
	/**
	 * builds the widget front end output
	 * including the before and after parts
	 */
	function widget( $args, $instance ) {
		
		$featured_post_query_args = array(
			'post_type'			=> ffpw_post_types(),
			'posts_per_page'	=> 1,
			'meta_key'			=> '_ffpw_featured',
			'meta_value'		=> 1,
			//'fields'			=> 'ids'
		);
		
		/* check whether we should be showing a random featured post rather than the latest one */
		if( $instance[ 'random_post' ] == 1 ) {
			
			/* add to our query arg for getting a random post */
			$featured_post_query_args[ 'orderby' ] = 'rand';
			
		}
		
		/* setup a query to get the featured post */
		$ffpw_post = new WP_Query( apply_filters( 'ffpw_featured_post_query_args', $featured_post_query_args ) );
		
		/* check if we have featured posts to show */
		if( $ffpw_post->have_posts() ) {
			
			/* output the markup set before the widget */
			echo $before_widget;
			
			/* loop through the post */
			while( $ffpw_post->have_posts() ) : $ffpw_post->the_post();
				
				global $post;
				
				/**
				 * @hook ffpw_featured_post_output
				 * $param $title is the title to output
				 * $param $post is the object of the queried featured post
				 * @param $instance is an array of the widget instances
				 * @param $args is an array of the widget arguments e.g. before_widget
				 *
				 * do widget action to hook output to
				 */
				do_action( 'ffpw_featured_post_output', $args, $instance, $post );
			
			/* end loop */
			endwhile;
			
			/* output the after widget markup */
			echo $after_widget;
			
		} // end if have featured post
		
		/* reset query */
		wp_reset_query();
	
	}
	
	/**
	 * updates the widget options when saved
	 */
	function update( $new_instance, $old_instance ) {
		
		/* get the different settings fields */
		$fields = ffpw_widget_options_fields();
		
		/* check we have fields to loop through */
		if( ! empty( $fields ) ) {
			
			/* loop through each widget option */
			foreach( $fields as $field ) {
				
				/* switch depending on the type of field */
				switch( $field[ 'type' ] ) {
					
					/* if this is a text type input */
					case 'text' :
						
						/* save the new instance - escaping any html */
						$instance[ $field[ 'id' ] ] = esc_html( $new_instance[ $field[ 'id' ] ] );
						break;
					
					/* if this is a text type input */
					case 'number' :
						
						if( is_numeric( $new_instance[ $field[ 'id' ] ] ) ) {
							$instance[ $field[ 'id' ] ] = $new_instance[ $field[ 'id' ] ];
						} else {
							$instance[ $field[ 'id' ] ] = '';
						}
						break;
					
					/* if this is a textarea type input */
					case 'textarea' :
					
						/* can the current user use unfiltered html */
						if( current_user_can( 'unfiltered_html' ) ) {
							
							/* save the new instance - no sanitizing */
							$instance[ $field[ 'id' ] ] = $new_instance[ $field[ 'id' ] ];
						
						/* user not allowed unfiltered html */
						} else {
							
							/* save the new instance - escaping using post kses for sanitizing */
							$instance[ $field[ 'id' ] ] = stripslashes( wp_filter_post_kses( addslashes( $new_instance[ $field[ 'id' ] ] ) ) );
							
						}
												
						break;
						
					/* if this field is a checkbox type input */
					case 'checkbox' :
						
						/* save the new instance - either one or zero */
						$instance[ $field[ 'id' ] ] = $new_instance[ $field[ 'id' ] ] ? 1 : 0;
						break;
					
					/* if this field is a select type input */
					case 'select' :
						
						/* save the new instance - either one or zero */
						$instance[ $field[ 'id' ] ] = esc_attr( $new_instance[ $field[ 'id' ] ] );
						break;
					
					default:
						break;
					
				} // end switch field type
				
			}
			
		} // end if have fields
		
		return $instance;
		
	}
	
	/**
	 * outputs the widget form in the admin
	 */ 
	function form( $instance ) {
		
		/* get the different settings fields */
		$fields = ffpw_widget_options_fields();
		
		/* check we have fields to loop through */
		if( ! empty( $fields ) ) {
			
			/* loop through each widget option */
			foreach( $fields as $field ) {

				/* if the field is set */
				if( isset( $instance[ $field[ 'id' ] ] ) ) {
					$value = $instance[ $field[ 'id' ] ];
				} else {
					$value = '';
				}

				/* if this field has a class */
				if( !is_null( $field[ 'class' ] ) ) {
					$field_class = ' ffpw-widget-field ' . $field[ 'class' ];
				} else {
					$field_class = ' ffpw-widget-field';
				}
				
				?>
				<p class="<?php echo esc_attr( $field_class ); ?>">
				<?php
				
				/* switch depending on the type of field */
				switch( $field[ 'type' ] ) {
										
					/* if this is a text type */
					case 'text' :
						
						?>
						
						<label for="<?php echo esc_attr( $this->get_field_id( $field[ 'id' ] ) ); ?>">
							<?php _e( esc_html( $field[ 'label' ] ) . ':', 'flexible-featured-post-widget' ); ?>
							<input class="widefat" id="<?php echo esc_attr( $this->get_field_id( $field[ 'id' ] ) ); ?>" name="<?php echo esc_attr( $this->get_field_name( $field[ 'id' ] ) ); ?>" type="text" value="<?php echo esc_html( $value ); ?>" />
						</label>
						
						<?php
						break;
					
					/* if this is a number type */
					case 'number' :
						
						?>
						
						<label for="<?php echo esc_attr( $this->get_field_id( $field[ 'id' ] ) ); ?>">
							<?php _e( esc_html( $field[ 'label' ] ) . ':', 'flexible-featured-post-widget' ); ?>
							<input class="widefat" id="<?php echo esc_attr( $this->get_field_id( $field[ 'id' ] ) ); ?>" name="<?php echo esc_attr( $this->get_field_name( $field[ 'id' ] ) ); ?>" type="number" value="<?php echo esc_html( $value ); ?>" />
						</label>
						
						<?php
						break;
					
					/* if thie field is a checbox type */
					case 'checkbox' :
						
						/* get the current status of the checkbox */
						$checked = $value ? 'checked="checked"' : '';
						
						?>
							
						<input type="checkbox" type="checkbox<?php echo esc_attr( $field_class ); ?>" <?php echo $checked; ?> id="<?php echo esc_attr( $this->get_field_id( $field[ 'id' ] ) ); ?>" name="<?php echo esc_attr( $this->get_field_name( $field[ 'id' ] ) ); ?>" />
						<label for="<?php echo esc_attr( $this->get_field_id( $field[ 'id' ] ) ); ?>"><?php _e( esc_html( $field[ 'label' ] ), 'flexible-featured-post-widget' ); ?></label>
						
						<?php
						break;
					
					/* if this is a textarea field type */
					case 'textarea' :
						
						?>
						
						<label for="<?php echo esc_attr( $this->get_field_id( $field[ 'id' ] ) ); ?>">
							<?php _e( esc_html( $field[ 'label' ] ) . ':', 'flexible-featured-post-widget' ); ?><br />
							<textarea class="widefat<?php echo esc_attr( $field_class ); ?>" id="<?php echo esc_attr( $this->get_field_id( $field[ 'id' ] ) ); ?>" name="<?php echo esc_attr( $this->get_field_name( $field[ 'id' ] ) ); ?>" type="text"><?php echo $value; ?></textarea>
						</label>
						
						<?php
						break;
					
					/* if this is a select field type */
					case 'select' :
																
						?>
						
						<label for="<?php echo esc_attr( $this->get_field_id( $field[ 'id' ] ) ); ?>"><?php _e( esc_html( $field[ 'label' ] ) . ':', 'flexible-featured-post-widget' ); ?></label>
						
						<select id="<?php echo $this->get_field_id( $field[ 'id' ] ); ?>" name="<?php echo $this->get_field_name( $field[ 'id' ] ); ?>">
							
							<option value="0"><?php _e( '&mdash; Select &mdash;', 'flexible-featured-post-widget' ); ?></option>
							
							<?php
								
								/* loop through each select option for this field */
								foreach( $field[ 'options' ] as $select_value => $label ) {
									
									?>
									<option value="<?php echo esc_attr( $select_value ); ?>" <?php echo selected( $value, $select_value ); ?>><?php echo esc_html( $label ); ?></option>
									<?php
									
								}	
								
							?>
							
						</select>
						
						<?php
						break;
											
					default:
						
						do_action( 'ffpw_widget_options_field_type' . $field[ 'type' ], $field, $value );
						break;
					
				}
				
				/* if the field has a description */
				if( $field[ 'desc' ] != '' ) {
					
					/* output the description */
					echo '<span class="widget-field-description"><em>' . esc_html( $field[ 'desc' ] ) . '</em></span>';
					
				}
				
				?>
				</p>
				<?php
				
			} // end loop through field
			
		} // end if we have fields to show
		
	}
	
}

/**
 * function ffpw_register_widget()
 *
 * registers the widget with wordpress
 */
function ffpw_register_widget() {
	
	/* register the widget */
	register_widget( 'FFPW_Flexible_Featured_Post' );
	
}

add_action( 'widgets_init', 'ffpw_register_widget' );