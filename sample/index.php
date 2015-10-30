<?php

date_default_timezone_set('Europe/Madrid'); // Avoid possible PHP warnings

require_once __DIR__.'/../vendor/autoload.php';
require_once __DIR__.'/environment-and-credentials.php';

use nkm\RedsysVirtualPos\Message\WebRequest;
use nkm\RedsysVirtualPos\Field\Currency;
use nkm\RedsysVirtualPos\Field\TransactionType;
use Rocket\UI\Table\Table;
use Monolog\Logger;
use Monolog\Handler\StreamHandler;


// Set up Logging
$log = new Logger('requests');
$log->pushHandler(new StreamHandler(__DIR__.'/requests.log'));


// Host Info
$proto = isset($_SERVER['HTTPS']) ? 'https://' : 'http://';
$host  = isset($_SERVER['HTTP_HOST']) ? $_SERVER['HTTP_HOST'] : 'localhost';


// Setup the Parameters for the Request
$params['Amount']             = '145';
$params['Order']              = strval(time());
$params['MerchantCode']       = $credentials['merchantCode'];
$params['Currency']           = Currency::EUR;
$params['TransactionType']    = TransactionType::STANDARD;
$params['Terminal']           = $credentials['terminal'];
$params['MerchantName']       = 'Test Store';
$params['ProductDescription'] = 'Product Description';
$params['UrlOK']              = $proto.$host.'/success.php';
$params['UrlKO']              = $proto.$host.'/failure.php';
$params['MerchantURL']        = $proto.$host.'/response.php'; // Only for Test, Integration and Live Environments

// Generate the Request
$webRequest = new WebRequest($env, $log);
$webRequest->setParams($params);
$submitBtn = "<p><input type='submit' name='submit' value='Submit' class='btn btn-primary btn-lg btn-block'></p>";

// Environment Information
$eiCaption = 'Environment Information';
$envInfo = [];
$envInfo['Name']     = $env->getName();
$envInfo['Endpoint'] = $webRequest->getEndpoint();
$envInfo['Secret']   = $env->getSecret();

// Request Parameters
$rpCaption = 'Request Parameters';
$requestParams = $webRequest->getParams();
$rpValues = [];
foreach ($requestParams as $k => $v) {
    $rpValues[ $v->getRequestName() ] = $v->getValue();
}

// Envelop Parameters Table
$epCaption = 'Envelop Parameters';
$envelopParams = $webRequest->getEnvelopParams();
$epValues = [];
foreach ($envelopParams as $k => $v) {
    $epValues[ $v->getRequestName() ] = $v->getValue();
}


/**
 * LOGGING
 */
$webRequest->log('debug', $eiCaption, $envInfo);  // Environment Info
$webRequest->log('debug', $epCaption, $epValues); // Envelop Params
$webRequest->log('debug', $rpCaption, $params);   // Request Params
$webRequest->log('debug', str_repeat('-', 42));   // Separator :3


/**
 * REPORT TABLES
 */

// Request Parameters
$rpTableRows = [];
foreach ($rpValues as $k => $v) {
    $rpTableRows[] = [
        [
            'class' => 'name',
            'data'  => $k,
        ],
        [
            'class' => 'value',
            'data'  => $v,
        ],
    ];
}

// Environment Information
$eiTableRows = [];
foreach ($envInfo as $k => $v) {
    $eiTableRows[] = [
        [
            'class' => 'name',
            'data'  => $k,
        ],
        [
            'class' => 'value',
            'data'  => $v,
        ],
    ];
}

// Envelop Parameters
$epTableRows = [];
foreach ($epValues as $k => $v) {
    $epTableRows[] = [
        [
            'class' => 'name',
            'data'  => $k,
        ],
        [
            'class' => 'value',
            'data'  => $v,
        ],
    ];
}

$eiTableRows || $eiTableRows = [[['colspan' => 2, 'data' => 'No data']]];
$epTableRows || $epTableRows = [[['colspan' => 2, 'data' => 'No data']]];
$rpTableRows || $rpTableRows = [[['colspan' => 2, 'data' => 'No data']]];

$eiTable = Table::quick(['Name', 'Value'], $eiTableRows, [], $eiCaption); // Environment Info
$epTable = Table::quick(['Name', 'Value'], $epTableRows, [], $epCaption); // Envelop Params
$rpTable = Table::quick(['Name', 'Value'], $rpTableRows, [], $rpCaption); // Request Params
$wrForm = $webRequest->getForm([], $submitBtn);                           // HTML Form

?>
<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>Web Request &middot; RedsysVirtualPos Sample</title>

    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.5/css/bootstrap.min.css" integrity="sha512-dTfge/zgoMYpP7QbHy4gWMEGsbsdZeCXz7irItjcC3sPUFtf0kuFbDz/ixG7ArTxmDjLXDmezHubeNikyKGVyQ==" crossorigin="anonymous">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.5/css/bootstrap-theme.min.css" integrity="sha384-aUGj/X2zp5rLCbBxumKTCw2Z50WgIr1vs/PFN4praOTvYXWlVyh2UtNUU0KAUhAX" crossorigin="anonymous">
    <link rel="stylesheet" href="styles.css">
  </head>

  <body>

    <nav class="navbar navbar-inverse navbar-static-top">
      <div class="container">
        <div class="navbar-header">
          <a class="navbar-brand" href="/">RedsysVirtualPos Sample</a>
        </div>
      </div>
    </nav>

    <div class="container">
      <div class="page-header">
        <h1>Web Request</h1>
      </div>

      <div class="row">
        <div class="col-md-8">
<?php if (!empty($rpTable)): ?>
          <?= $rpTable ?>
<?php endif ?>
<?php if (!empty($epTable)): ?>
          <?= $epTable ?>
<?php endif ?>
        </div>
        <div class="col-md-4">
<?php if (!empty($eiTable)): ?>
          <?= $eiTable ?>
<?php endif ?>
<?php if (!empty($wrForm)): ?>
          <?= $wrForm ?>
<?php endif ?>
        </div>
      </div>

  </body>
</html>
