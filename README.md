jsonrates - Currency exchange rates API client
=========

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

The API documentation can be found at: [jsonrates.com/docs](http://jsonrates.com/docs/)

##### Basic usage

``` php
include_once 'Jsonrates.php';
$jsonrates = new Jsonrates();
```

###### Example: Get an exchange rate for two currencies

``` php
$rate = $jsonrates
  ->from('USD')
  ->to('EUR')
  ->get();
```

###### Example: Convert an USD amount to all other available currencies

``` php
$rate = $jsonrates
  ->base('USD')
  ->amount(2.99)
  ->convert();
```

###### Example: Get a timeseries of rates for two currencies

``` php
$rate = $jsonrates
  ->from('XBT')
  ->to('USD')
  ->dateStart('2014-11-02')
  ->dateEnd('2014-11-05')
  ->historical();
```

###### Example: Get an exchange rate for the currencies of two locales

``` php
$rate = $jsonrates
  ->from('en_GB')
  ->to('de_DE')
  ->locale();
```