<p align="center">
<a href="https://packagist.org/packages/laralabs/get-address-io"><img src="https://poser.pugx.org/laralabs/get-address-io/version" alt="Stable Build" /></a>
<a href="https://github.com/Laralabs/get-address-io/actions"><img src="https://github.com/clnt/scrubber/actions/workflows/.github-actions.yml/badge.svg" alt="CI Status" /></a>
<a href="https://codecov.io/gh/Laralabs/get-address-io"><img src="https://codecov.io/gh/Laralabs/get-address-io/branch/master/graph/badge.svg?token=S2VO0QHCP8"/></a>
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

The facade is located at `Laralabs\GetAddress\Facades\GetAddress`

The endpoints currently supported are (support for other endpoints coming soon):
- find
- autocomplete
- get

Perform a lookup using the `find` endpoint:
```php
$results = get_address()->find($postcode, $property);
```

The `$property` argument is optional, just searching for a postcode will return all results for that postcode and also cache the data if the cache has been enabled.

Perform a looking using the `autocomplete` endpoint:
```php
$results = get_address()->autocomplete($searchTerm, ['top' => '20']);
```

The second argument supports an array of parameters to send with the POST request, the example above shows setting the returned results to the maximum allowed of 20.

Perform a lookup using the `get` endpoint:
```php
$results = get_address()->get($addressId);
```

This is used with the `autocomplete` endpoint to return the full address information, the `$addressId` argument must be the ID returned from the autocomplete response.

## :speech_balloon: Support

Please raise an issue on GitHub if there is a problem.

## :key: License

This is open-sourced software licensed under the [MIT License](http://opensource.org/licenses/MIT).