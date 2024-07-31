;( function ( $, window, undefined ) {

	if ( $( '.digifly-subscription-callout-wrapper' ).length > 0 ) {
		// Overtake the form submission request
		$( '.digifly-subscription-form' ).on(
			'submit',
			function( e ) {
				e.preventDefault();

				if ( $( '.digifly-subscription-callout' ).hasClass( 'digifly-ajaxing' ) ) {
					return; // request is already in progress
				}

				$( '.digifly-subscription-callout' ).addClass( 'digifly-ajaxing' );

				$.ajax(
					{
						url: ajaxurl,
						type: 'POST',
						dataType: 'JSON',
						data: {
							action: 'digifly_handle_subscription_request',
							email: $( '.digifly-subscription-form input' ).val(),
							security: $( '.digifly-subscription-form input[name="_wpnonce"]' ).val(),
							from_callout: 1,
						},
						success: function( data ) {
							$( '.digifly-subscription-callout-main' ).hide();
							$( '.digifly-subscription-callout-thanks' ).show();
						}
					}
				)
				.fail(
					function() {
						$( '.digifly-subscription-error' ).show();
					}
				)
				.always(
					function() {
						$( '.digifly-subscription-callout' ).removeClass( 'digifly-ajaxing' );
					}
				);
			}
		);
	}

}( jQuery, window ) );
