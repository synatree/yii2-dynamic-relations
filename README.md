Dynamic Relations Extension
===========================
Allows Yii2 views to contain a dynamically expanding set of fields based on model relations.

Installation
------------

The preferred way to install this extension is through [composer](http://getcomposer.org/download/).

Either run

```
php composer.phar require --prefer-dist synatree/yii2-dynamic-relations "*"
```

or add

```
"synatree/yii2-dynamic-relations": "*"
```

to the require section of your `composer.json` file.


Usage
-----

Once the extension is installed, simply use it in your code by  :

```php
<?= \synatree\dynamicrelations\AutoloadExample::widget(); ?>```