# Redsys Virtual POS

[![Build Status](https://travis-ci.com/bahiazul/redsys-virtual-pos.png?branch=master)](https://travis-ci.com/bahiazul/redsys-virtual-pos)
[![Latest Stable Version](https://poser.pugx.org/bahiazul/redsys-virtual-pos/v/stable)](https://packagist.org/packages/bahiazul/redsys-virtual-pos)
[![Total Downloads](https://poser.pugx.org/bahiazul/redsys-virtual-pos/downloads)](https://packagist.org/packages/bahiazul/redsys-virtual-pos)
[![Latest Unstable Version](https://poser.pugx.org/bahiazul/redsys-virtual-pos/v/unstable)](https://packagist.org/packages/bahiazul/redsys-virtual-pos)
[![License](https://poser.pugx.org/bahiazul/redsys-virtual-pos/license)](https://packagist.org/packages/bahiazul/redsys-virtual-pos)

**Redsys Virtual POS** is an _unofficial_ standalone PHP library to handle payments through the spanish payment service Redsys.

> **NOTE:** This library its still under development and its functionality is subject to change.

## Prerequisites

-   PHP >=5.4.0 <8.0

## Installation

Installation is recommended through [Composer](https://getcomposer.org/).

```
$ composer require bahiazul/redsys-virtual-pos
```

## Sample

Go to the `sample` folder an run the following command in a terminal to start PHP's built-in web server:

```
# install dependencies
$ composer install

# start the server
$ php -S 0.0.0.0:8000
```

Then open your browser and go to [here](http://localhost:8000/).

If you want to test the online (async) response, replace `localhost` with your public IP or hostname, making sure that your machine is accesible through the port 8000 (you can use another port if you want).

## Usage

Basic usage:

```php
use Bahiazul\RedsysVirtualPos\Message\WebRequest;
use Bahiazul\RedsysVirtualPos\Field\Currency;
use Bahiazul\RedsysVirtualPos\Field\TransactionType;

$secret       = 'Mk9m98IfEblmPfrpsawt7BmxObt98Jev';
$merchantCode = '999008881';
$terminal     = '871';

// The Environment object holds connection details
$env = new Bahiazul\RedsysVirtualPos\Environment\DevelopmentEnvironment();
$env->setSecret($secret);

// Setup the Parameters for the Request
$params['Amount']             = '145'; // €1,45
$params['Order']              = strval(time());
$params['MerchantCode']       = $merchantCode;
$params['Currency']           = Currency::EUR;
$params['TransactionType']    = TransactionType::STANDARD;
$params['Terminal']           = $terminal;
$params['MerchantName']       = 'Test Store';                        // optional
$params['ProductDescription'] = 'Product Description';               // optional
$params['UrlOk']              = 'http://localhost:8000/success.php'; // optional
$params['UrlKo']              = 'http://localhost:8000/failure.php'; // optional

// Generate the Request
$webRequest = new WebRequest($env);
$webRequest->setParams($params);

// Generate the form
$submitBtn = "<p><input type='submit' value='Submit'></p>";
$wrForm = $webRequest->getForm([], $submitBtn);

// Render the HTML form w/ Submit button
echo $wrForm;
```

See `sample/index.php` and `sample/response.php` for more detailed examples.

## Test

Run the following command in a terminal:

```
# install dependencies
$ composer install

# run the tests
$ phpunit
```

## Changelog

See [CHANGELOG.md](CHANGELOG.md)

## Authors

-   [Javier Zapata](https://javi.io) ([Twitter](https://twitter.com/jzfgo))

## License

MIT
