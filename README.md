## Laravel Expose
[![License](https://poser.pugx.org/scollins/laravel-expose/license)](https://packagist.org/packages/scollins/laravel-expose)
[![Latest Stable Version](https://poser.pugx.org/scollins/laravel-expose/v/stable)](https://packagist.org/packages/scollins/laravel-expose)
[![Total Downloads](https://poser.pugx.org/scollins/laravel-expose/downloads)](https://packagist.org/packages/scollins/laravel-expose)

This package allows you to use [Expose](https://github.com/enygma/expose) in Laravel with support for caching ad queuing.

### This package is currently in Alpha and has not yet been released. As with all packages use at your own risk.

## Install
First grab a copy with composer
```bash
$ composer require scollins/laravel-expose dev-master
```

You can also manually add it to your composer.json and run `composer update`
```json
{
    "require": {
        "scollins/laravel-expose": "dev-master"
    }
}
```

Add the service provider to your `config\app.php` file

* `SCollins\LaravelExpose\ExposeServiceProvider::class`

Add the facade

* `'Expose' => SCollins\LaravelExpose\Facades\Expose::class`

Add the Middleware to your `kernel.php`

* `\SCollins\LaravelExpose\Middleware\Expose::class`

It should now run on any requests with input and add the Job to your queue.
While your queue is running it will analyse the requests and log any high values. 

## License
Laravel Expose is licensed under [The MIT License (MIT)](LICENSE).

