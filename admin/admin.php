<?php
/**
 * function ffpw_featured_post_checkbox()
 * outputs the checkbox to mark a page as the contact page
 */
function ffpw_featured_post_checkbox() {
	
	/* only do this for ffpw post types */
	if( ! in_array( get_post_type(), ffpw_post_types() ) ) {
		return;
	}
	
	/* add a nonce field so we can check for it later */
	wp_nonce_field( 'ffpw_featured_post_checkbox', 'ffpw_featured_post_checkbox_nonce' );
		
	?>
	
	<div class="misc-pub-section ffpw-featured-post">
		<input type="hidden" name="ffpw_featured_post" value="0" />
		<input id="ffpw_featured_post" type="checkbox" name="ffpw_featured_post" value="1" <?php checked( 1, get_post_meta( $_GET[ 'post' ], '_ffpw_featured', true ) ); ?> />
		<label for="ffpw_featured_post">Make featured</label>
	</div>
	
	<?php
	
}

add_action( 'post_submitbox_misc_actions', 'ffpw_featured_post_checkbox' );

/**
 * function ffpw_contact_page_checkbox_save()
 * saves the checkbox marking a page as the contact page
 */
function ffpw_featured_post_checkbox_save( $post_id ) {
	
	/* only do this for ffpw post types */
	if( ! in_array( get_post_type( $post_id ), ffpw_post_types() ) ) {
		return;
	}
	
	/* check if our nonce is se */
	if ( ! isset( $_POST[ 'ffpw_featured_post_checkbox_nonce' ] ) ) {
		return;
	}
	
	/* verify that the nonce is valid */
	if ( ! wp_verify_nonce( $_POST[ 'ffpw_featured_post_checkbox_nonce' ], 'ffpw_featured_post_checkbox' ) ) {
		return;
	}
	
	/* if this is an autosave, our form has not been submitted, so we don't want to do anything */
	if ( defined( 'DOING_AUTOSAVE' ) && DOING_AUTOSAVE ) {
		return;
	}
	
	/* check the current user can edit this post */
	if ( ! current_user_can( 'edit_post', $post_id ) ) {
		return;
	}
		
	/* if the box has beeb ticked */
	if( isset( $_POST[ 'ffpw_featured_post' ] ) ) {
		
		/* update post meta with the contact page value */
		update_post_meta( $post_id, '_ffpw_featured', $_POST[ 'ffpw_featured_post' ] );
		
	}
	
}

add_action( 'save_post', 'ffpw_featured_post_checkbox_save' );