<?php

date_default_timezone_set('Europe/Madrid');

require_once __DIR__ . '/../vendor/autoload.php';

use nkm\RedsysVirtualPos\Message\WebResponse;
use nkm\RedsysVirtualPos\Field\Currency;
use nkm\RedsysVirtualPos\Field\TransactionType;
use Monolog\Logger;
use Monolog\Handler\StreamHandler;

// Logging
$log = new Logger('responses');
$log->pushHandler(new StreamHandler(__DIR__.'/responses.log'));


$secret = 'sq7HjrUOBfKmC576ILgskD5srU870gJ7';

$env = new nkm\RedsysVirtualPos\Environment\TestEnvironment();
$env->setSecret($secret);


$webResponse = new WebResponse($env, $log);
$webResponse->setPostParams($_POST); // #YOLO
$webResponse->log('debug', 'POST received', $_POST);

$responseParams = $webResponse->getParams();
foreach ($responseParams as $k => $v) {
    $params[$k] = $v->getValue();
}
$isValid          = $webResponse->getIsValid();
$validationErrors = $webResponse->getValidationErrors();


if ($isValid) {
    $webResponse->log('debug', 'Response is VALID', $params);
} else {
    $webResponse->log('debug', 'Response is NOT VALID', $params);
    $webResponse->log('debug', 'Validation Errors', $validationErrors);
}

if (isset($responseParams['Response'])) {
    $responseCode = [];
    $responseCode['type']             = $responseParams['Response']->getType();
    $responseCode['title']            = $responseParams['Response']->getTitle();
    $responseCode['description']      = $responseParams['Response']->getDescription();
    $responseCode['typeDescription']  = $responseParams['Response']->getTypeDescription($responseCode['type']);
    $responseCode['isApproved']       = $responseParams['Response']->getIsApproved();
    $responseCode['isRejected']       = $responseParams['Response']->getIsRejected();
    $responseCode['isCancelOrRefund'] = $responseParams['Response']->getIsCancelOrRefund();
    $responseCode['isReconOrPreauth'] = $responseParams['Response']->getIsReconOrPreauth();
    $responseCode['isError']          = $responseParams['Response']->getIsError();

    $webResponse->log('debug', 'Response Info', $responseCode);
}

if (isset($responseParams['ErrorCode'])) {
    $errorCode = [];
    $errorCode['reason']             = $responseParams['ErrorCode']->getReason();
    $errorCode['message']            = $responseParams['ErrorCode']->getMessage();
    $errorCode['messageDescription'] = $responseParams['ErrorCode']->getMessageDescription($errorCode['message']);

    $webResponse->log('debug', 'Error Info', $errorCode);
}
