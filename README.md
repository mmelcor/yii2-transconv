Yii2 PHP to PO translation file converter
=========================================
A program to convert php translation files to po translation files.

Installation
------------

The preferred way to install this extension is through [composer](http://getcomposer.org/download/).

Either run

```
php composer.phar require --prefer-dist mmelcor/yii2-transconv "*"
```

or add

```
"mmelcor/yii2-transconv": "*"
```

to the require section of your `composer.json` file.


Usage
-----

Once the extension is installed, simply use it in your code by adding the following to your console\config\main-local.php file (advanced) or config\console.php (basic) :

```php
return [
	'bootstrap' => [ '[Other boostrap items]', 'transconv'],
	'modules' => [
		'[other modules]' => '[other module paths]',
		'transconv' => 'mmelcor\yii2transconv\Module',
	],
];
```
Then you can call 
```
php yii transconv path/to/messages/
```

Before or after the conversion make sure that your i18n.php and i18n configuration have been set to use po files according to the Yii2 Internationalization setup. For more info see [Yii2 Documentation](http://www.yiiframework.com/doc-2.0/guide-tutorial-i18n.html).