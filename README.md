Yii Pickadate.js Widget
=======================

This is a wrapper to use the [pickadate.js](http://amsul.ca/pickadate.js/index.htm) library with the Yii framework (PHP).

Requirements
------------

* Yii 1.1.14 or above
* PHP 5.3 or above

License
-------

This extension is free software, available under the terms of [MIT License](https://github.com/vundicind/yii-pickadate/blob/master/LICENSE).

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

Configuration
-------------

If you installed the extension via Composer then you have to add the following alias to the config file:

```php
    'aliases' => array(
        ...
        'pickadate' => realpath(__DIR__ . '/../../vendor/vundicind/yii-pickadate/src'),
        ...
    ),
```

Otherwise:

```php
    'aliases' => array(
        ...
        'pickadate' => realpath(__DIR__ . '/../extensiosn/yii-pickadate/src'),
        ...
    ),
```


Usage
-----

### Date picker

Minimal code to insert in a Yii view to get *Date picker* widget working:

```php
<?php
$this->widget('pickadate.DatePickerWidget', array(
    'model' => $model,
    'attribute'=> 'modified_date'
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
    'attribute'=> 'modified_date',
    'htmlOptions' => array('class' => 'input-small'),
    'options' => array(
        'format' => 'yyyy-mm-dd',
        'selectYears' => true,
        'selectMonths' => true,
    ),
    'events' => array(
        'onSet' => 'function(context) {
            if(typeof context.select != "undefined")
                console.log("Hello: Date selected!");
        }'
    )
));
?>
````

### Time picker

Minimal code to insert in a Yii view to get *Time picker* widget working:

```php
<?php
$this->widget('pickadate.TimePickerWidget', array(
    'model' => $model,
    'attribute'=> 'modified_time'
));
?>
```

or you can:

```php
<?php
$this->widget('pickadate.TimePickerWidget');
?>
```

Tips & Tricks
-------------

### Events

As was noted above one can handle Picker events using the `events` array, but they may be added also to the `options` array wrapped in a CJavaScriptExpression object:

```php
<?php
$this->widget('pickadate.DatePickerWidget', array(
    'model' => $model,
    'attribute'=> 'modified_date',
    'htmlOptions' => array('class' => 'input-small'),
    'options' => array(
        'format' => 'yyyy-mm-dd',
        'selectYears' => true,
        'selectMonths' => true,
        'onSet' => new CJavaScriptExpression('function(context) {
            if(typeof context.select != "undefined")
                console.log("Hello: Date selected!");
        }')
    )
));
?>
```

### JavaScript dates

One can pass JavaScript dates to *Time picker* in the following way:

```php
<?php
$this->widget('pickadate.TimePickerWidget', array(
    'options' => array(
        'min' => new CJavaScriptExpression('new Date(2013, 3, 20, 10)'),
        'min' => new CJavaScriptExpression('new Date(2013, 4, 2, 20)')
    )
));
?>
```

Credits
-------

Certain ideas have been inspired by [Yii Pickadate.js Widget](https://github.com/bromden/YiiPickadateWidget).
