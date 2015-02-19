jsonrates - Currency exchange rates API
=========

[![Build Status](https://travis-ci.org/jsonrates/php-client.svg?branch=master)](https://travis-ci.org/jsonrates/php-client)

The jsonrates API provides reliable, fast and free exchange rates and currency conversion for 168 currencies.
All exchange rates are updated every 10 minutes and were collected from several providers.
jsonrates is perfect for developers who need a free and simple service for getting exchange rates
instead of paying hundreds of dollar for the most providers.

##### Functions
* Exchange Rates
* Currency Conversion
* Historical Data
* Locale Transformation

Website: [jsonrates.com](http://jsonrates.com/)

Installation
-----

##### Via composer
Install the latest version with `composer require jsonrates/api-client`

``` php
require 'vendor/autoload.php';
$jsonrates = new \Jsonrates\Client();
```

##### Manually
Download and extract the `latest release` to `/your/libs/jsonrates/`

``` php
require_once '/your/libs/jsonrates/php-client/src/Jsonrates/Client.php';
$jsonrates = new \Jsonrates\Client();
```

Usage
-----

##### Example: Get an exchange rate for two currencies

``` php
$result = $jsonrates
  ->from('USD')
  ->to('EUR')
  ->get();
```

##### Example: Convert an USD amount to all other available currencies

``` php
$result = $jsonrates
  ->base('USD')
  ->amount(2.99)
  ->convert();
```

##### Example: Get a timeseries of rates for two currencies

``` php
$result = $jsonrates
  ->from('XBT')
  ->to('USD')
  ->dateStart('2014-11-02')
  ->dateEnd('2014-11-05')
  ->historical();
```

##### Example: Get an exchange rate for the currencies of two locales

``` php
$result = $jsonrates
  ->from('en_GB')
  ->to('de_DE')
  ->locale();
```

API Documentation
-----
See: [jsonrates.com/docs](http://jsonrates.com/docs/)
