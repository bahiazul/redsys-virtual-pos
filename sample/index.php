<?php

date_default_timezone_set('Europe/Madrid');

require_once __DIR__ . '/../vendor/autoload.php';

use nkm\RedsysVirtualPos\Environment\TestEnvironment;
use nkm\RedsysVirtualPos\Message\WebRequest;
use nkm\RedsysVirtualPos\Message\WebResponse;
use nkm\RedsysVirtualPos\Field\Currency;

$secret = 'qwertyasdf0123456789';

$env = new nkm\RedsysVirtualPos\Environment\TestEnvironment();
$env->setSecret($secret);

$setRequestParams = [];
$setRequestParams['amount']             = '24995';
$setRequestParams['currency']           = Currency::EUR;
$setRequestParams['merchantcode']       = '327234688';
$setRequestParams['merchantname']       = 'Comercio en pruebas';
$setRequestParams['order']              = '141020090000';
$setRequestParams['productdescription'] = 'Descripción del producto';
$setRequestParams['terminal']           = '1';
$setRequestParams['merchanturl']        = 'https://example.com/redsys/receiver';
$setRequestParams['urlok']              = 'https://example.com/order/checkout/confirmation.html';
$setRequestParams['urlko']              = 'https://example.com/order/checkout/failure.html';

$webRequest = new WebRequest($env);
$webRequest->setParams($setRequestParams);

$submitBtn = "<input type='submit' name='submit' value='Submit'>";

var_dump($webRequest->getIsValid());
var_dump($webRequest->getValidationErrors());

$setResponseParams = [];
$setResponseParams['ds_transactiontype']   = '0';
$setResponseParams['ds_card_country']      = '280';
$setResponseParams['ds_date']              = '20/10/2014';
$setResponseParams['ds_securepayment']     = '1';
$setResponseParams['ds_order']             = '141020090000';
$setResponseParams['ds_hour']              = '09:00';
$setResponseParams['ds_response']          = '0000';
$setResponseParams['ds_authorisationcode'] = '123456';
$setResponseParams['ds_currency']          = '978';
$setResponseParams['ds_consumerlanguage']  = '5';
$setResponseParams['ds_merchantcode']      = '327234688';
$setResponseParams['ds_amount']            = '24995';
$setResponseParams['ds_terminal']          = '001';
$setResponseParams['ds_signature']         = strtoupper(sha1(
    $setResponseParams['ds_amount'].
    $setResponseParams['ds_order'].
    $setResponseParams['ds_merchantcode'].
    $setResponseParams['ds_currency'].
    $setResponseParams['ds_response'].
    $secret
));
$responseParams['ds_errorcode'] = 'SIS9951';

$webResponse = new WebResponse($env);
$webResponse->setParams($setResponseParams);

var_dump($webResponse->getIsValid());
var_dump($webResponse->getValidationErrors());

$responseParams = $webResponse->getParams();

if (isset($setResponseParams['ds_response'])) {
    $responseCode = [];
    $responseCode['type']             = $responseParams['ds_response']->getType();
    $responseCode['title']            = $responseParams['ds_response']->getTitle();
    $responseCode['description']      = $responseParams['ds_response']->getDescription();
    $responseCode['typeDescription']  = $responseParams['ds_response']->getTypeDescription($responseCode['type']);
    $responseCode['isApproved']       = $responseParams['ds_response']->getIsApproved();
    $responseCode['isRejected']       = $responseParams['ds_response']->getIsRejected();
    $responseCode['isCancelOrRefund'] = $responseParams['ds_response']->getIsCancelOrRefund();
    $responseCode['isReconOrPreauth'] = $responseParams['ds_response']->getIsReconOrPreauth();
    $responseCode['isError']          = $responseParams['ds_response']->getIsError();

    echo '<pre>';
    var_dump($responseCode);
    echo '</pre>';
}

if (isset($setResponseParams['ds_errorcode'])) {
    $errorCode = [];
    $errorCode['field']              = $responseParams['ds_errorcode']->getField();
    $errorCode['reason']             = $responseParams['ds_errorcode']->getReason();
    $errorCode['message']            = $responseParams['ds_errorcode']->getMessage();
    $errorCode['messageDescription'] = $responseParams['ds_errorcode']->getMessageDescription($errorCode['message']);

    echo '<pre>';
    var_dump($errorCode);
    echo '</pre>';
}

?>
<html>
    <head>
        <meta charset="utf-8">
    </head>
    <body>
        <?php echo $webRequest->getForm([], $submitBtn); ?>
    </body>
</html>
