Cacheable
=========

> Automatically cache Eloquent models using the `find` methods

[![License](http://img.shields.io/badge/license-MIT-brightgreen.svg?style=flat-square)](http://www.opensource.org/licenses/MIT)
[![Latest Version](http://img.shields.io/packagist/v/pulkitjalan/cacheable.svg?style=flat-square)](https://packagist.org/packages/pulkitjalan/cacheable)
[![Total Downloads](https://img.shields.io/packagist/dt/pulkitjalan/cacheable.svg?style=flat-square)](https://packagist.org/packages/pulkitjalan/cacheable)

## Requirements

- PHP >= 5.5.9
- Laravel >= 5.1

## Installation

Install via [composer](https://getcomposer.org/) - edit your `composer.json` to require the package.

```js
"require": {
    "pulkitjalan/cacheable": "dev-master"
}
```

Then run `composer update` in your terminal to pull it in.

This package makes use of [pulkitjalan\multicache](https://github.com/pulkitjalan/multicache) which requires a service provider to be registered. So add the following to the `providers` array in your `config/app.php`

```php
PulkitJalan\Cache\Providers\MultiCacheServiceProvider::class
```

## Usage

Simply use the `Cacheable` trait in any model you want to be cache automatically.

```php
<?php

namespace App;

use PulkitJalan\Cacheable\Cacheable;

class Model extends \Eloquent
{
    use Cacheable;
}
```

Caching the model only works with using the `find`, `findMany` or `findOrFail` methods.

If you would like caching behavior like in Laravel 4 then consider using [dwightwatson/rememberable](https://github.com/dwightwatson/rememberable) which adds the `remember` function back into eloquent.