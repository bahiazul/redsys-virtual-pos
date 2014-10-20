<?php

date_default_timezone_set('Europe/Madrid');

require_once __DIR__ . '/../vendor/autoload.php';

use nkm\RedsysVirtualPos\Environment\TestEnvironment;
use nkm\RedsysVirtualPos\Message\WebRequest;
use nkm\RedsysVirtualPos\Message\WebResponse;
use nkm\RedsysVirtualPos\Field\Currency;

$env = new nkm\RedsysVirtualPos\Environment\LiveEnvironment();
$env->setSecret('ab12cd3e4fg56h7ijk89');

$webRequest = new WebRequest($env);
$webRequest->setParams([
    'amount'             => '24995',
    'currency'           => Currency::EUR,
    'merchantCode'       => '345678901',
    'merchantName'       => 'Comercio en pruebas',
    'order'              => '141020090000',
    'productDescription' => 'Descripción del producto',
    'terminal'           => '1',
    'merchantUrl'        => 'https://example.com/redsys/receiver',
    'urlOk'              => 'https://example.com/order/checkout/confirmation.html',
    'urlKo'              => 'https://example.com/order/checkout/failure.html',
]);

$submitBtn = "<input type='submit' name='submit' value='Submit'>";

var_dump($webRequest->getIsValid());
var_dump($webRequest->getValidationErrors());

$webResponse = new WebResponse($env);
$webResponse->setParams([
    'transactionType'   => '0',
    'cardCountry'       => '280',
    'date'              => '20/10/2014',
    'securePayment'     => '1',
    'signature'         => 'B3BA068B98FFFE4F2D717DA35E8855D10BDE4798',
    'order'             => '141020090000',
    'hour'              => '09:00',
    'response'          => '0000',
    'authorisationCode' => '123456',
    'currency'          => '978',
    'consumerLanguage'  => '5',
    'merchantCode'      => '345678901',
    'amount'            => '24995',
    'terminal'          => '001',
]);

var_dump($webResponse->getIsValid());
var_dump($webResponse->getValidationErrors());

?>
<html>
    <body>
        <?php echo $webRequest->getForm([], $submitBtn); ?>
    </body>
</html>
