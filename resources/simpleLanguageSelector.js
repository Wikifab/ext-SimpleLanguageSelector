
( function ( $, mw ) {
	'use strict';
	
	mw.sls = mw.sls || {};

	var wgSimpleLangageSelectionLangList = mw.config.get('wgSimpleLangageSelectionLangList');

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
		var userLanguage = $('.sls-trigger').attr('class').split('lang-')[1];
		if(!wgSimpleLangageSelectionLangList.includes(userLanguage)){
			var modalLanguage = $('#sls-language-selection-modal');
			modalLanguage.find('.close').attr('disabled', true);
			modalLanguage.find('#cancel').attr('disabled', true);
			modalLanguage.modal();
		}
		$('.sls-changeLanguageLink').click(function() {
			var modalLanguage = $('#sls-language-selection-modal');
			if(modalLanguage.find('.close').attr('disabled')) {
				modalLanguage.find('.close').attr('disabled', false);
				modalLanguage.find('#cancel').attr('disabled', false);
			}
			mw.sls.changeLanguage(($(this).data( "code" )));
		});
		
		$('.sls-trigger').click(function(item) {
			$( "#sls-language-selection-modal" ).modal();
		});
	});

}( jQuery, mediaWiki ) );
