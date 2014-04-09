Yii Pickadate.js Widget
=======================

This is a wrapper to use the [pickadate.js](http://amsul.ca/pickadate.js/index.htm) library with the Yii framework (PHP).

Requirements
------------

* Yii 1.1.14 or above
* PHP 5.3 or above

License
-------

This extension is free software, available under the terms of a [MIT(-style) open source license](https://github.com/vundicind/yii-pickadate/blob/master/LICENSE).

Installation
-------------

### Installing with Composer

If you use [Composer](https://getcomposer.org/) to manage your project dependencies, you can install *yii-pickadate*
using the following commands:

```shell
php composer.phar config repositories.yii-pickadate vcs http://github.com/vundicind/yii-pickadate
php composer.phar require vundicind/yii-pickadate dev-master
```

### Installing by hand

Extract the contents of the archive under `protected/extensions/`.

Usage
-----

### Date picker

Minimal code to insert in a Yii view to get *Date picker* widget working:

```php
<?php
$this->widget('pickadate.DatePickerWidget', array(
    'model' => $model,
    'attribute'=> 'modified_at'
));
?>
````

or you can:

````php
<?php
$this->widget('pickadate.DatePickerWidget');
?>
````

Also you can:
* configure the style of input HTML element (with [Bootstrap](http://getbootstrap.com/2.3.2/base-css.html#forms) classes for example);
* change the display format of the selected date;
* and set an event handler.

```php
<?php
$this->widget('pickadate.DatePickerWidget', array(
    'model' => $model,
    'attribute'=> 'modified_at',
    'htmlOptions' => array('class' => 'input-small'),
    'options' => array(
        'format' => 'yyyy-mm-dd',
        'selectYears' => true,
        'selectMonths' => true,
    ),
    'events' => array(
        'onSet' => 'function(context) {
            if(typeof context.select != "undefined")
                console.log("Date selected!");
        }'
    )
));
?>
````

Tips & Tricks
-------------

Credits
-------

Certain ideas have been inspired by [Yii Pickadate.js Widget](https://github.com/bromden/YiiPickadateWidget).
