( function( $ ) {
	
	function hideToggleHideElements() {
		
		var ffpwShowFeatured	= $( '.ffpw-show-featured-image input' ).is(':checked');
		var ffpwReadmoreLink	= $( '.ffpw-show-readmore-link input' ).is(':checked');
		var ffpwExcerpt			= $( '.ffpw-show-excerpt input' ).is(':checked');
		
		if( ffpwShowFeatured == false ) {
			$( '.ffpw-featured-image-size' ).hide();
		}
		
		if( ffpwReadmoreLink == false ) {
			$( '.ffpw-readmore-text' ).hide();
		}
		
		if( ffpwExcerpt == false ) {
			$( '.ffpw-excerpt-length' ).hide();
		}
		
	}
	
	function toggleCheckboxDependencies() {
		
		$( '.ffpw-show-featured-image input' ).click( function() {
			$( '.ffpw-featured-image-size' ).toggle();
		});
		
		$( '.ffpw-show-readmore-link input' ).click( function() {
			$( '.ffpw-readmore-text' ).toggle();
		});
		
		$( '.ffpw-show-excerpt input' ).click( function() {
			$( '.ffpw-excerpt-length' ).toggle();
		});
			
	}
	
	$(document).ready( function() {
		hideToggleHideElements();
		toggleCheckboxDependencies();
	});
	
	$(document).on( 'widget-updated', function(e, widget) {
		hideToggleHideElements();
		toggleCheckboxDependencies();
	});
	
} )( jQuery );