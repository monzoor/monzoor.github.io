/**
 * modalEffects.js v1.0.0
 * http://www.codrops.com
 *
 * Licensed under the MIT license.
 * http://www.opensource.org/licenses/mit-license.php
 * 
 * Copyright 2013, Codrops
 * http://www.codrops.com
 */
var ModalEffects = (function($) {

	function init() {

		if ( $('.md-trigger').length ) {

 			$('.md-trigger').each( function() {
				var d = this,
					modal = $( '#' + $(this).data('modal') ),
					close = modal.find( '.md-close' ),
					overlay = $( '.md-overlay' );

				function removeModal( hasPerspective ) {
					modal.removeClass('md-show');

					if ( hasPerspective ) {
						$('html').removeClass('md-perspective');
					}
				}

				function removeModalHandler() {
					removeModal( $(d).hasClass('md-setperspective') ); 
				}

				$(d).on( 'click', function( ev ) {
					ev.preventDefault();
					modal.addClass('md-show');

					overlay.unbind().on( 'click', function(){ 
						removeModalHandler();
					});

					if ( $(d).hasClass('md-setperspective') ) {
						setTimeout( function() {
							$('html').addClass('md-perspective');
						}, 25 );
					}
				});



				$(close).unbind().on( 'click', function( ev ) {
					ev.preventDefault();
					removeModalHandler();
				});

			} );
		}
	}

	init();

})( window.jQuery );