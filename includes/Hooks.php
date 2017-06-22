<?php
namespace SimpleLanguageSelector;

use Language;
use RequestContext;

class Hooks {

	/**
	 * @param OutputPage $out
	 * @param Skin $skin
	 * @return bool
	 * Hook: BeforePageDisplay
	 */
	public static function addModules( $out, $skin ) {
		$out->addModules( 'ext.simplelanguageselector' );

		$out->addHTML(self::getLanguageSelectorBoxHtml());
	}

	public static function getLanguageSelectorBoxHtml() {
		$ret = "\n";

		$ret .= '<div id="sls-language-selection-modal" class="modal fade" role="dialog">
		  <div class="modal-dialog">

		    <!-- Modal content-->
		    <div class="modal-content">
		      <div class="modal-header">
		        <button type="button" class="close" data-dismiss="modal">&times;</button>
		        <h4 class="modal-title">'.wfMessage('sls-select-language')->plain() .'</h4>
		      </div>
		      <div class="modal-body">';

		$languages = [
				'fr' => 'Francais',
				'en' => 'English',
				'es' => 'Español',
				'it' => 'Italiano'
		];

		$ret .= "\n<ul>\n";
		foreach ($languages as $code => $languageName) {
			$ret .= '<li class="sls-changeLanguageLink" data-code="'.$code.'"><a>'.$languageName.'</a></li>';
		}
		$ret .= "\n</ul>\n";

		$ret .= '
			        <p>'.wfMessage('sls-select-other-languages-info', '<a href="#">' . wfMessage('sls-select-other-languages-tradlink') . '</a>')->plain() .'</p>
			      </div>
			      <div class="modal-footer">
			        <button type="button" class="btn btn-default" data-dismiss="modal">'.wfMessage('cancel')->plain().'</button>
			      </div>
			    </div>

			  </div>
			</div>';
		return $ret;
	}

	/**
	 * Add some tabs for navigation for users who do not use Ajax interface.
	 * Hook: PersonalUrls
	 */
	public static function addPersonalBarTrigger( array &$personal_urls, &$title ) {


		$context = RequestContext::getMain();

		// The element id will be 'pt-uls'
		$langCode = $context->getLanguage()->getCode();
		$personal_urls = [
				'language' => [
						'text' => Language::fetchLanguageName( $langCode ),
						'href' => '#',
						'class' => 'sls-trigger lang-' . $langCode,
						'data-code' => $langCode,
						'active' => true
				]
		] + $personal_urls;

		return true;
	}

}