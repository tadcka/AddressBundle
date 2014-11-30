AddressBundle
=============

[![SensioLabsInsight](https://insight.sensiolabs.com/projects/f568a9bf-e77e-486c-be85-8b313464268e/big.png)](https://insight.sensiolabs.com/projects/f568a9bf-e77e-486c-be85-8b313464268e)

Full control the user's address on Symfony2

## Installation

### Step 1: Download TadckaAddressBundle using composer

Add TadckaAddressBundle in your composer.json:

```js
{
    "require": {
        "tadcka/address-bundle": "dev-master"
    }
}
```

Now tell composer to download the bundle by running the command:

``` bash
$ php composer.phar update tadcka/address-bundle
```

### Step 2: Enable the bundle

Enable the bundle in the kernel:

``` php
<?php
// app/AppKernel.php

public function registerBundles()
{
    $bundles = array(
        // ...
        new Tadcka\AddressBundle\TadckaAddressBundle(),
    );
}
```

### Step 3: Update doctrine schema

``` bash
$ php app/console doctrine:schema:update --dump-sql
```

### Step 4: Create form

Create form builder and add address form:

``` php
$builder->add(
	'address',
	'tadcka_address',
	array(
		'_locale' => 'en'
	)
);
```

### Step 5: Include javascript and css

```twig
@TadckaAddressBundle/Resources/public/css/address.css

@TadckaAddressBundle/Resources/public/js/address.js
```

```js
$(document).ready(function () {
    $('div#tadcka_address_form').address_form();
});
```

Authors
---------

The bundle was originally created by Tadas Gliaubicas. See the list of [contributors](https://github.com/tadcka/AddressBundle/contributors).
