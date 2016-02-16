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
];```