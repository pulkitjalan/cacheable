Cacheable
=========

> Automatically cache basic Eloquent models using the `find` methods

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
    "pulkitjalan/cacheable": "0.1.*"
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

use Illuminate\Database\Eloquent\Model;
use PulkitJalan\Cacheable\Cacheable;

class CachedModel extends Model
{
    use Cacheable;
}
```

Caching the model only works with using the `find`, `findMany` or `findOrFail` methods.

If you would like caching behavior like in Laravel 4 then consider using [dwightwatson/rememberable](https://github.com/dwightwatson/rememberable) which adds the `remember` function back into eloquent.

You can optinally set the expiry time in minutes for the model, by default it is set to `1440` minutes (24 hours).

```php
<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use PulkitJalan\Cacheable\Cacheable;

class CachedModel extends Model
{
    use Cacheable;

    /**
     * Set the cache expiry time.
     *
     * @var int
     */
    public $cacheExpiry = 60;
}
```

Models are cached using the models `table name` as the cache tag and the `id` as the key. There are observers which get registered in the trait to also remove from cache when the `saved` or `deleted`.

Caching is only applied to basic models (ones without any conditions added).

```php
// cached
CachedModel::find(1);

// not cached
CachedModel::where('some_field', 1)->find(1);
```
