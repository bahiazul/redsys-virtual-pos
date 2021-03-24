# Redsys Virtual POS

[![Build Status](https://travis-ci.org/jzfgo/redsys-virtual-pos.png?branch=master)](https://travis-ci.org/jzfgo/redsys-virtual-pos)
[![Latest Stable Version](https://poser.pugx.org/nkm/redsys-virtual-pos/v/stable)](https://packagist.org/packages/nkm/redsys-virtual-pos)
[![Total Downloads](https://poser.pugx.org/nkm/redsys-virtual-pos/downloads)](https://packagist.org/packages/nkm/redsys-virtual-pos)
[![Latest Unstable Version](https://poser.pugx.org/nkm/redsys-virtual-pos/v/unstable)](https://packagist.org/packages/nkm/redsys-virtual-pos)
[![License](https://poser.pugx.org/nkm/redsys-virtual-pos/license)](https://packagist.org/packages/nkm/redsys-virtual-pos)

**Redsys Virtual POS** is an _unofficial_ standalone PHP library to handle payments through the spanish payment service Redsys.

> **NOTE:** This library its still under development and its functionality is subject to change.

## Prerequisites

-   PHP 5.4 or above

## Installation

Installation is recommended through [Composer](https://getcomposer.org/).

```
$ composer require nkm/redsys-virtual-pos
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
use nkm\RedsysVirtualPos\Message\WebRequest;
use nkm\RedsysVirtualPos\Field\Currency;
use nkm\RedsysVirtualPos\Field\TransactionType;

$secret       = 'Mk9m98IfEblmPfrpsawt7BmxObt98Jev';
$merchantCode = '999008881';
$terminal     = '871';

// The Environment object holds connection details
$env = new nkm\RedsysVirtualPos\Environment\DevelopmentEnvironment();
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

### Version 0.4.6 (24 March 2021)

-   Update test suite.

### Version 0.4.5 (24 March 2021)

-   Add response field: `Ds_ProcessedPayMethod`.

### Version 0.4.4 (11 March 2021)

-   Replace deprecated `mcrypt_encrypt()` by `openssl_encrypt()`.

### Version 0.4.3 (11 March 2021)

-   Fix class name casing for [PSR-4](https://www.php-fig.org/psr/psr-4/) compliance.

### Version 0.4.2 (7 April 2020)

-   Normalize documentation filenames

### Version 0.4.1 (7 April 2020)

-   Hotfix

### Version 0.4.0 (6 April 2020)

-   Add request fields: `Ds_Merchant_Acquirer_Identifier`, `Ds_Merchant_Cof_Ini`, `Ds_Merchant_Cof_Txnid`, `Ds_Merchant_Cof_Type`, `Ds_Merchant_Customer_Mail`, `Ds_Merchant_Customer_Mobile`, `Ds_Merchant_Customer_Sms_Text`, `Ds_Merchant_Dcc`, `Ds_Merchant_DirectPayment`, `Ds_Merchant_Emv3ds`, `Ds_Merchant_Excep_Sca`, `Ds_Merchant_Group`, `Ds_Merchant_Identifier`, `Ds_Merchant_IdOper`, `Ds_Merchant_MatchingData`, `Ds_Merchant_MerchantDescriptor`, `Ds_Merchant_MpiExternal`, `Ds_Merchant_P2f_ExpiryDate`, `Ds_Merchant_P2f_XmlData`, `Ds_Merchant_PayMethods`, `Ds_Merchant_PersoCode`, `Ds_Merchant_ShippingAddressPyp`, `Ds_Merchant_Tax_Reference`, `Ds_Merchant_Terminal`, `Ds_Merchant_Titular`, `Ds_Merchant_TransactionDate`, `Ds_Merchant_TransactionType`, `Ds_Merchant_UrlKo`, `Ds_Merchant_UrlOk`, `Ds_Merchant_XPayData`, `Ds_Merchant_XPayOrigen` and `Ds_Merchant_XPayType`
-   Add response fields: `Codigo`, `Ds_Merchant_Cof_Txnid`, `Ds_DCC`, `Ds_Merchant_Identifier` and `Ds_UrlPago2Fases`
-   Update field name cases
-   Add documentation

### Version 0.3.4 (19 April 2017)

-   Add undocumented field `DS_Card_Brand`

### Version 0.3.3 (26 April 2016)

-   Add undocumented field `DS_MerchantPartialPayment` (only used by CaixaBank’s Cyberpac)
-   Add documentation for CaixaBank’s Cyberpac
-   Update Redsys’ official documentation

### Version 0.3.2 (1 November 2015)

-   Fix field names on params array indices
-   Fix missing case-sensitive renames (OSX, Y U NO CS?)
-   Refactoring of the Sample

### Version 0.3.1 (30 October 2015)

-   Minor fixes in sample

### Version 0.3.0 (30 October 2015)

-   Add support new cryptographic algorithm (SHA-2, HMAC_SHA256_V1) for message signing
-   Update for the new Redsys API
-   General overhaul and simplification
-   Improve sample with request/response support, logging and detailed reporting
-   Update documentation (Redsys and Banco Sabadell)

### Version 0.2.0 (29 October 2014)

-   Handle unknown or empty Error and Response codes gracefully

### Version 0.1.3 (27 October 2014)

-   Translate response type descriptions and error messages to Spanish for consistency
-   Improve naming of response types
-   `Response::getType()` now returns the type name instead of its description
-   Rename `AbstractMessage::getFieldClassName()` to `AbstractMessage::resolveFieldClassName()`
-   Lowercase field key names in order to ease integration with databases
-   Add method `Field\Response::getTypeDescription()`
-   Other minor fixes and improvements

### Version 0.1.2 (21 October 2014)

-   Rename the response fields to match Redsys's Online Response ones
-   Add Error Code field to the Response
-   Add source implementation docs

### Version 0.1.0 (20 October 2014)

Initial (stealth) release

## Authors

-   [Javier Zapata](https://javi.io) ([Twitter](https://twitter.com/jzfgo))

## License

The BSD 3-Clause License

Copyright (c) 2015-2021, Javier Zapata
All rights reserved.

Redistribution and use in source and binary forms, with or without modification, are permitted provided that the following conditions are met:

1. Redistributions of source code must retain the above copyright notice, this list of conditions and the following disclaimer.

2. Redistributions in binary form must reproduce the above copyright notice, this list of conditions and the following disclaimer in the documentation and/or other materials provided with the distribution.

3. Neither the name of the copyright holder nor the names of its contributors may be used to endorse or promote products derived from this software without specific prior written permission.

THIS SOFTWARE IS PROVIDED BY THE COPYRIGHT HOLDERS AND CONTRIBUTORS "AS IS" AND ANY EXPRESS OR IMPLIED WARRANTIES, INCLUDING, BUT NOT LIMITED TO, THE IMPLIED WARRANTIES OF MERCHANTABILITY AND FITNESS FOR A PARTICULAR PURPOSE ARE DISCLAIMED. IN NO EVENT SHALL THE COPYRIGHT HOLDER OR CONTRIBUTORS BE LIABLE FOR ANY DIRECT, INDIRECT, INCIDENTAL, SPECIAL, EXEMPLARY, OR CONSEQUENTIAL DAMAGES (INCLUDING, BUT NOT LIMITED TO, PROCUREMENT OF SUBSTITUTE GOODS OR SERVICES; LOSS OF USE, DATA, OR PROFITS; OR BUSINESS INTERRUPTION) HOWEVER CAUSED AND ON ANY THEORY OF LIABILITY, WHETHER IN CONTRACT, STRICT LIABILITY, OR TORT (INCLUDING NEGLIGENCE OR OTHERWISE) ARISING IN ANY WAY OUT OF THE USE OF THIS SOFTWARE, EVEN IF ADVISED OF THE POSSIBILITY OF SUCH DAMAGE.
