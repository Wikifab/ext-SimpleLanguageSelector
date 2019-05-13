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

		$out->addModuleStyles(
				array(
						'ext.simplelanguageselectorcss'
				)
		);

		$out->addHTML(self::getLanguageSelectorBoxHtml());
	}

	public static function getLanguageSelectorBoxHtml() {
		global $wgSimpleLangageSelectionLangList, $wgScriptPath, $wgSimpleLangageSelectionShowTranslateLink;


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



		$ret .= "\n<ul class='sls-language-list row'>\n";
		foreach ($wgSimpleLangageSelectionLangList as $code) {
			$languageName = ucfirst(Language::fetchLanguageName( $code ));
			$ret .= '<li class="col-md-6 col-xs-12 sls-changeLanguageLink sls-lang-link sls-lang-link-'.$code.'" data-code="'.$code.'"><a>'.
						'<img class="sls-flagimage" src="'.$wgScriptPath.'/extensions/SimpleLanguageSelector/resources/flags/'.$code.'.png" alt = '.$code.'/>
						'.$languageName.'</a>'.
					'</li>';
		}
		$ret .= "\n</ul>\n";

		if ($wgSimpleLangageSelectionShowTranslateLink) {
			$url = 'http://translate.wikifab.org';
			$ret .= '
			        <p class="sls-messageInfo">'
			        . wfMessage('sls-select-other-languages-info', '<a href="' . $url . '" target="_blank">' . $url . '</a>')->plain()
			        . '</p>
			';
		}

		$ret .= '
			      </div>
			      <div class="modal-footer">
			        <button type="button" class="btn btn-default" id="cancel" data-dismiss="modal">'.wfMessage('cancel')->plain().'</button>
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
		global $wgScriptPath;

		$context = RequestContext::getMain();
		// The element id will be 'pt-uls'
		$langCode = $context->getLanguage()->getCode();

		$html = '<li id="pt-language" class="active"><a href="#" class="sls-trigger lang-'.$langCode.'"><img class="sls-flagimage" title="'.Language::fetchLanguageName( $langCode ).'" src="'.$wgScriptPath.'/extensions/SimpleLanguageSelector/resources/flags/'.$langCode.'.png" alt = '.$langCode.'/></a></li>';

		$personal_urls = [
				'language' => [
						'html' => $html,//Language::fetchLanguageName( $langCode ),
						'text' => Language::fetchLanguageName( $langCode ),
						'href' => '#',
						'class' => 'sls-trigger lang-' . $langCode,
						'data-code' => $langCode,
						'active' => true
				]
		] + $personal_urls;

		return true;
	}

	public static function onUserGetLanguageObject($user, &$code){
		global $wgSimpleLangageSelectionLangList;
		if(!in_array($code, $wgSimpleLangageSelectionLangList)){
			$code = 'en';
		}
	}

}