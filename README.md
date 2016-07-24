Stay up to date by following @apilayernet on Twitter.
____________

currencylayer API - PHP client
=========

Currencylayer provides a JSON-based REST API, delivering reliable and accurate currency exchange rates for 168 world currencies and precious metals at an affordable price, which makes it the perfect instrument for startups and online businesses, as well as for larger companies in need of reliable financial data via an easy to use interface. The currencylayer API is widely used to power financial departments, mobile applications and back-office systems around the world.

##### Features
* Real-time Exchange Rates
* Historical Rates back to 1999
* Currency Conversion
* Time-Frame Queries
* Currency-Change Queries

Website: [currencylayer.com](https://currencylayer.com/)

Installation
-----

#### With Composer *RECOMMENDED*
```
composer require oceanapplications/currencylayer-php-client
```

```
Use OceanApplications\currencylayer;

$currencylayer = new currencylayer\client('API Key');
```

#### without composer
Download and extract the `latest release` to `/your/libs/currencylayer/`
``` php
require_once '/your/libs/currencylayer/php-client/src/currencylayer/client.php';
$currencylayer = new \currencylayer\client('YOUR_ACCESS_KEY');
```


Usage
-----

##### Example: Request real-time rates via "live" endpoint

``` php
$result = $currencylayer
  ->source('USD')
  ->currencies('JPY,GBP,AUD')
  ->live();
```


##### Example: Request historical rates via "historical" endpoint

``` php
$result = $currencylayer
  ->date('2015-01-01')
  ->source('USD')
  ->currencies('JPY,GBP,AUD')
  ->historical();
```


##### Example: Convert currencies via "convert" endpoint

``` php
$result = currencylayer
  ->from('USD')
  ->to('JPY')
  ->amount('10')
  ->date('2015-01-01')
  ->convert();
```


##### Example: Request time-frame (time-series) data via "timeframe" endpoint

``` php
$result = $currencylayer
  ->source('USD')
  ->currencies('JPY,GBP,AUD')
  ->start_date('2014-01-01')
  ->end_date('2014-02-01')
  ->timeframe();
```


##### Example: Request currency-change data via "change" endpoint

``` php
$result = $currencylayer
  ->source('USD')
  ->currencies('JPY,GBP,AUD')
  ->start_date('2014-01-01')
  ->end_date('2014-02-01')
  ->change();
```

API Documentation
-----
See: [currencylayer.com/documentation](https://currencylayer.com/documentation)
