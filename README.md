
## SimpleLanguageSelector

SimpleLanguageSelector is a mediawiki extension add an icone with a language chooser. It is optimized for chameleon and Wikifab.

To be used with Translate extension.

This uses Flags to select Languages. Note that this is not a good way to select languages (flags represents countries, not languages) But you may still want to use flags...


## Installation

It requires wikifab chameleon skin.

Extract extension and place it in the 'extensions' directory of your installation. (the directory namme must be 'SimpleLanguageSelector')

Load extension and enable setting page Language in DB in file LocalSetting.php, et configure UniversalLanguageExtension to be enable, and not displayd : 

```
wfLoadExtension( 'SimpleLanguageSelector' );
```

## Configuration 

Set the languages to use with $wgSimpleLangageSelectionLangList:

```
$wgSimpleLangageSelectionLangList = ['fr', 'en', 'es'];
```

availables lang : 
* de
* en
* es
* fr
* it
* pt
* sv

To add link to translate wikifab, add this config in LocalSettings.php :
```
$wgSimpleLangageSelectionShowTranslateLink = true;
```

## How to add an available lang :

* add flag png to flags dir (use one from flags/countries)
* add css : (example for FR )
 #pt-language .sls-trigger.lang-fr {
 	/* @embed */
 	background-image: url('flags/fr.png')
 }