<?php

date_default_timezone_set('Europe/Madrid');

require_once __DIR__ . '/../vendor/autoload.php';

use nkm\RedsysVirtualPos\Message\WebRequest;
use nkm\RedsysVirtualPos\Message\WebResponse;
use nkm\RedsysVirtualPos\Field\Currency;
use nkm\RedsysVirtualPos\Field\TransactionType;
use Rocket\UI\Table\Table;
use Monolog\Logger;
use Monolog\Handler\StreamHandler;

// Logging
$log = new Logger('requests');
$log->pushHandler(new StreamHandler(__DIR__.'/requests.log'));


// You should request this to your bank
$secret       = '01234567890012345678901234567890';
$merchantCode = '012345678';

$env = new nkm\RedsysVirtualPos\Environment\TestEnvironment();
$env->setSecret($secret);

$requestParams = [];
$requestParams['Amount']             = '100';
$requestParams['Order']              = strval(time());
$requestParams['MerchantCode']       = $merchantCode;
$requestParams['Currency']           = Currency::EUR;
$requestParams['TransactionType']    = TransactionType::STANDARD;
$requestParams['Terminal']           = '1';
$requestParams['MerchantName']       = 'Test Store';
$requestParams['ProductDescription'] = 'Product Description';
$requestParams['MerchantURL']        = 'http://local.yourdomain.com:8000/response.php';
$requestParams['UrlOK']              = 'http://localhost:8000/success.html';
$requestParams['UrlKO']              = 'http://localhost:8000/failure.html';


$webRequest = new WebRequest($env, $log);
$webRequest->setParams($requestParams);
$webRequest->log('debug', 'Request params', $requestParams);

$submitBtn = "<input type='submit' name='submit' value='Submit' style='width:300px;font-size:'>";

$tableRows = [];
foreach($requestParams as $k => $v) {
    $tableRows[] = [$k, $v];
}
$tableAttrs  = [
    'border'      => 1,
    'cellpadding' => 5,
    'cellspacing' => 0,
    'style'       => 'margin:0 auto;',
];

?>
<html>
    <head>
        <meta charset='utf-8'>
    </head>
    <body style='text-align:center'>
        <?= Table::quick(['Name','Value'], $tableRows, $tableAttrs, 'Request Parameters'); ?>
        <p><?= $webRequest->getForm([], $submitBtn); ?></p>
    </body>
</html>
