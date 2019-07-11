<p align="center">
    <img src="http://assets.laralabs.uk/images/logos/laralabs_logo_big.png" height="267px" width="182px" />
</p>
<p align="center">
<a href="https://packagist.org/packages/laralabs/get-address-io"><img src="https://poser.pugx.org/laralabs/get-address-io/version" alt="Stable Build" /></a>
<a href="https://travis-ci.org/Laralabs/get-address-io"><img src="https://travis-ci.org/Laralabs/get-address-io.svg?branch=master" alt="Build Status"></a>
<a href="https://styleci.io/repos/195806527"><img src="https://styleci.io/repos/195806527/shield?branch=master" alt="StyleCI"></a>
<a href="https://codeclimate.com/github/Laralabs/get-address-io/maintainability"><img src="https://api.codeclimate.com/v1/badges/744992b1495722bd6839/maintainability" /></a>
<a href="https://codeclimate.com/github/Laralabs/get-address-io/test_coverage"><img src="https://api.codeclimate.com/v1/badges/744992b1495722bd6839/test_coverage" /></a>
</p>

# Laravel getAddress.io Package

This package allows you to easily interact with the [getAddress.io](https://getaddress.io/) API and cache full postcode results to reduce quota usage.

## :rocket: Quick Start

### Installation
Require the package in the `composer.json` of your project.
```
composer require laralabs/get-address-io
```
Publish the configuration file.
```
php artisan vendor:publish --tag=getaddress-config
```
Edit the configuration file and set your desired settings, the cache is disabled by default and you will need to set the following env variables:
```
GETADDRESS_API_KEY=
GETADDRESS_ADMIN_KEY=
```

If you have enabled the cache, make sure you run the migration:
```
php artisan migrate
```

### Usage
A helper function and facade is available, choose your preferred method.

Perform a lookup:
```php
$results = get_address()->find($postcode, $property);
```

Perform an expanded lookup:
```php
$results = get_address()->expand()->find($postcode, $property);
```

The `$property` argument is optional, just searching for a postcode will return all results for that postcode and also cache the data if the cache has been enabled.

## :pushpin: Todo

- Admin Features.
- Unit Tests.

## :speech_balloon: Support

Please raise an issue on GitHub if there is a problem.

## :key: License

This is open-sourced software licensed under the [MIT License](http://opensource.org/licenses/MIT).