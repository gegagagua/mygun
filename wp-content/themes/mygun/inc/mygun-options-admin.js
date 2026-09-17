/* MyGun Content — media picker for image fields */
( function ( $ ) {
	'use strict';

	var frame = null;
	var $activeField = null;

	$( document ).on( 'click', '.mygun-image-select', function ( e ) {
		e.preventDefault();
		$activeField = $( this ).closest( '.mygun-image-field' );

		frame = wp.media( {
			title: 'Select image',
			button: { text: 'Use this image' },
			library: { type: 'image' },
			multiple: false
		} );

		frame.on( 'select', function () {
			var attachment = frame.state().get( 'selection' ).first().toJSON();
			var url = ( attachment.sizes && attachment.sizes.medium ) ? attachment.sizes.medium.url : attachment.url;
			$activeField.find( '.mygun-image-id' ).val( attachment.id );
			$activeField.find( '.mygun-image-preview' ).html( '<img src="' + url + '" />' );
			$activeField.find( '.mygun-image-remove' ).show();
		} );

		frame.open();
	} );

	$( document ).on( 'click', '.mygun-image-remove', function ( e ) {
		e.preventDefault();
		var $field = $( this ).closest( '.mygun-image-field' );
		$field.find( '.mygun-image-id' ).val( '' );
		$field.find( '.mygun-image-preview' ).empty();
		$( this ).hide();
	} );
} )( jQuery );
