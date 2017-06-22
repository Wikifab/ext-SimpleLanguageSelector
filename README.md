
## SimpleLanguageSelector

SimpleLanguageSelector is a mediawiki extension add an icone with a language chooser. It is optimized for chameleon and Wikifab.

To be used with Translate extension.


## Installation

It requires wikifab chameleon skin.

Extract extension ant place it in the 'extensions' directory of your installation. (the directory namme must be 'SimpleLanguageSelector')

Load extension and enable setting page Language in DB in file LocalSetting.php, et configure UniversalLanguageExtension to be enable, and not displayd : 

```
wfLoadExtension( 'SimpleLanguageSelector' );
```

## Configuration 

Set the languages to use with $wgSimpleLangageSelectionLangList:

```
$wgSimpleLangageSelectionLangList = ['fr', 'en', 'es'];
```
