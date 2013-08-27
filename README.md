AddressBundle
=============

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



