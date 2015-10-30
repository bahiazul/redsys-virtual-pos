<?php

date_default_timezone_set('Europe/Madrid'); // Avoid possible PHP warnings

require_once __DIR__.'/../vendor/autoload.php';
require_once __DIR__.'/environment-and-credentials.php';

use nkm\RedsysVirtualPos\Message\WebResponse;
use Rocket\UI\Table\Table;
use Monolog\Logger;
use Monolog\Handler\StreamHandler;


// Set up Logging
$log = new Logger('responses');
$log->pushHandler(new StreamHandler(__DIR__.'/responses.log'));


// Generate the Response object
$webResponse = new WebResponse($env, $log);
$webResponse->setEnvelopeParams($_REQUEST); // #YOLO


// Validate the Response Signature
$rsIsValid = !$_REQUEST || ($_REQUEST && $webResponse->getIsValid());
if ($_REQUEST && !$rsIsValid) {
    $errors = $webResponse->getValidationErrors();
    is_array($errors) || $errors = [];
    $rsCaption = 'INVALID RESPONSE. '.implode(', ', $errors);
} else {
    $rsCaption = 'VALID RESPONSE';
}


// Environment Information
$envInfo = [];
$eiCaption = 'Environment Information';
$envInfo['Name']   = $env->getName();
$envInfo['Secret'] = $env->getSecret();

// Envelop Parameters
$epCaption = "Envelop Parameters ({$_SERVER['REQUEST_METHOD']})";

// Response Parameters
$rpValues = [];
$rpCaption = 'Response Parameters';
$responseParams = $webResponse->getParams();
foreach ($responseParams as $k => $v) {
    $rpValues[ $v->getResponseName() ] = $v->getValue();
}

// Response Information
$responseInfo = [];
$responseInfo['type']            = $responseParams['Response']->getType();
$responseInfo['typeDescription'] = $responseParams['Response']->getTypeDescription($responseInfo['type']);
$responseInfo['title']           = $responseParams['Response']->getTitle();
$responseInfo['description']     = $responseParams['Response']->getDescription();
$riCaption = 'Response Information';

// Error Information
$errorCode = [];
$erCaption = 'Error Information';
if (isset($responseParams['ErrorCode'])) {
    $errorCode['reason']             = $responseParams['ErrorCode']->getReason();
    $errorCode['message']            = $responseParams['ErrorCode']->getMessage();
    $errorCode['messageDescription'] = $responseParams['ErrorCode']->getMessageDescription($errorCode['message']);
}


/**
 * LOGGING
 */
$webResponse->log('debug', $rsCaption);                // Response Signature
$webResponse->log('debug', $eiCaption, $envInfo);      // Environment Info
$webResponse->log('debug', $epCaption, $_REQUEST);     // Envelop Params
$webResponse->log('debug', $rpCaption, $rpValues);     // Request Params
$webResponse->log('debug', $riCaption, $responseInfo); // Request Info
$webResponse->log('debug', $erCaption, $errorCode);    // Error Info
$webResponse->log('debug', str_repeat('-', 42));       // Separator :3


/**
 * REPORT TABLES
 */

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
foreach ($_REQUEST as $k => $v) {
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

// Response Parameters
$rpTableRows = [];
foreach ($responseParams as $k => $v) {
    $rpTableRows[] = [
        [
            'class' => 'name',
            'data'  => $v->getResponseName(),
        ],
        [
            'class' => 'value',
            'data'  => $v->getValue(),
        ],
    ];
}

// Response Information
$riTableRows = [];
foreach ($responseInfo as $k => $v) {
    $riTableRows[] = [
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

// Error Information
$erTableRows = [];
if (isset($errorCode)) {
    foreach ($errorCode as $k => $v) {
        $erTableRows[] = [
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
}

$eiTableRows || $eiTableRows = [[['colspan' => 2, 'data' => 'No data']]];
$epTableRows || $epTableRows = [[['colspan' => 2, 'data' => 'No data']]];
$_REQUEST    || $rpTableRows = [[['colspan' => 2, 'data' => 'No data']]];
$_REQUEST    || $riTableRows = [[['colspan' => 2, 'data' => 'No data']]];
$erTableRows || $erTableRows = [[['colspan' => 2, 'data' => 'No data']]];

$eiTable = Table::quick(['Name', 'Value'], $eiTableRows, [], $eiCaption); // Environment Info
$epTable = Table::quick(['Name', 'Value'], $epTableRows, [], $epCaption); // Envelop Params
$rpTable = Table::quick(['Name', 'Value'], $rpTableRows, [], $rpCaption); // Request Params
$riTable = Table::quick(['Name', 'Value'], $riTableRows, [], $riCaption); // Request Info
$erTable = Table::quick(['Name', 'Value'], $erTableRows, [], $erCaption); // Error Info
