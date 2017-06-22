
( function ( $, mw ) {
	'use strict';
	
	mw.sls = mw.sls || {};

	/**
	 * Change the language of wiki using API or set cookie and reload the page
	 *
	 * @param {string} language Language code.
	 */
	mw.sls.changeLanguage = function ( language ) {
		var deferred = new $.Deferred();

		function changeLanguageAnon(language) {
			mw.cookie.set( 'language', language );

			/*
			var options = {};
			options.prefix = 'wikifab_i18n_wfpp_';
			mw.cookie.set( 'language', language , options);*/

			location.reload();
		}

		deferred.done( function () {
			var api;

			if ( mw.user.isAnon() ) {
				changeLanguageAnon(language);
				return;
			}
			
			api = new mw.Api();
			api.saveOption( 'language', language )
			.done( function () {
				location.reload();
			} )
			.fail( function () {
				// Set options failed. Maybe the user has logged off.
				// Continue like anonymous user and set cookie.
				changeLanguageAnon(language);
			} );
		} );

		mw.hook( 'mw.uls.interface.language.change' ).fire( language, deferred );

		deferred.resolve();
	};
	
	$(document).ready(function() {
		$('.sls-changeLanguageLink').click(function() {
			mw.sls.changeLanguage(($(this).data( "code" )));
		});
		
		$('.sls-trigger').click(function(item) {
			$( "#sls-language-selection-modal" ).modal();
		});
	});

}( jQuery, mediaWiki ) );
