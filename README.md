Redsys Virtual POS
==================

[![Build Status](https://travis-ci.org/nkm/redsys-virtual-pos.png?branch=master)](https://travis-ci.org/nkm/redsys-virtual-pos)

**Redsys Virtual POS** is an *unofficial* standalone PHP library to handle payments through the spanish payment service Redsys.

> **NOTE:** This library its been used in production for over a year now (as Oct. 2015) but its still under development and its functionality is subject to change.

Prerequisites
-------------

- PHP 5.4 or above

Installation
------------

Installation is recommended through [Composer](https://getcomposer.org/).

```
$ composer require nkm/redsys-virtual-pos
```

Sample
------

Go to the `sample` folder an run the following command in a terminal to start PHP's built-in web server:

```
$ php -S 0.0.0.0:8000
```

Then open your browser and go to [here](http://localhost:8000/).

If you want to test the online (async) response, replace `localhost` with your public IP or hostname, making sure that your machine is accesible through the port 8000 (you can use another port if you want).

Usage
-----

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
$params['UrlOK']              = 'http://localhost:8000/success.php'; // optional
$params['UrlKO']              = 'http://localhost:8000/failure.php'; // optional

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


Test
----

Run the following command in a terminal:

```
$ phpunit
```

Changelog
---------

### Version 0.3.2 (1 November 2015)

- Fix field names on params array indices
- Fix missing case-sensitive renames (OSX, Y U NO CS?)
- Sample refactoring

### Version 0.3.1 (30 October 2015)

- Minor fixes in sample

### Version 0.3.0 (30 October 2015)

- Add support new cryptographic algorithm (SHA-2, HMAC_SHA256_V1) for message signing
- Update for the new Redsys API
- General overhaul and simplification
- Improve sample with request/response support, logging and detailed reporting
- Update documentation (Redsys and Banco Sabadell)

### Version 0.2.0 (29 October 2014)

- Handle unknown or empty Error and Response codes gracefully

### Version 0.1.3 (27 October 2014)

- Translate response type descriptions and error messages to Spanish for consistency
- Improve naming of response types
- `Response::getType()` now returns the type name instead of its description
- Rename `AbstractMessage::getFieldClassName()` to `AbstractMessage::resolveFieldClassName()`
- Lowercase field key names in order to ease integration with databases
- Add method `Field\Response::getTypeDescription()`
- Other minor fixes and improvements

### Version 0.1.2 (21 October 2014)

- Rename the response fields to match Redsys's Online Response ones
- Add Error Code field to the Response
- Add source implementation docs

### Version 0.1.0 (20 October 2014)

Initial (stealth) release


Authors
-------

- [Javier Zapata](http://javi.io) ([Twitter](https://twitter.com/jzf82))

License
-------

The BSD 3-Clause License

Copyright (c) 2015, Javier Zapata
All rights reserved.

Redistribution and use in source and binary forms, with or without modification, are permitted provided that the following conditions are met:

1. Redistributions of source code must retain the above copyright notice, this list of conditions and the following disclaimer.

2. Redistributions in binary form must reproduce the above copyright notice, this list of conditions and the following disclaimer in the documentation and/or other materials provided with the distribution.

3. Neither the name of the copyright holder nor the names of its contributors may be used to endorse or promote products derived from this software without specific prior written permission.

THIS SOFTWARE IS PROVIDED BY THE COPYRIGHT HOLDERS AND CONTRIBUTORS "AS IS" AND ANY EXPRESS OR IMPLIED WARRANTIES, INCLUDING, BUT NOT LIMITED TO, THE IMPLIED WARRANTIES OF MERCHANTABILITY AND FITNESS FOR A PARTICULAR PURPOSE ARE DISCLAIMED. IN NO EVENT SHALL THE COPYRIGHT HOLDER OR CONTRIBUTORS BE LIABLE FOR ANY DIRECT, INDIRECT, INCIDENTAL, SPECIAL, EXEMPLARY, OR CONSEQUENTIAL DAMAGES (INCLUDING, BUT NOT LIMITED TO, PROCUREMENT OF SUBSTITUTE GOODS OR SERVICES; LOSS OF USE, DATA, OR PROFITS; OR BUSINESS INTERRUPTION) HOWEVER CAUSED AND ON ANY THEORY OF LIABILITY, WHETHER IN CONTRACT, STRICT LIABILITY, OR TORT (INCLUDING NEGLIGENCE OR OTHERWISE) ARISING IN ANY WAY OUT OF THE USE OF THIS SOFTWARE, EVEN IF ADVISED OF THE POSSIBILITY OF SUCH DAMAGE.
