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
    'Ds_TransactionType'   => '0',
    'Ds_Card_Country'      => '280',
    'Ds_Date'              => '20/10/2014',
    'Ds_SecurePayment'     => '1',
    'Ds_Signature'         => 'B3BA068B98FFFE4F2D717DA35E8855D10BDE4798',
    'Ds_Order'             => '141020090000',
    'Ds_Hour'              => '09:00',
    'Ds_Response'          => '0000',
    'Ds_AuthorisationCode' => '123456',
    'Ds_Currency'          => '978',
    'Ds_ConsumerLanguage'  => '5',
    'Ds_MerchantCode'      => '345678901',
    'Ds_Amount'            => '24995',
    'Ds_Terminal'          => '001',
]);

var_dump($webResponse->getIsValid());
var_dump($webResponse->getValidationErrors());

?>
<html>
    <body>
        <?php echo $webRequest->getForm([], $submitBtn); ?>
    </body>
</html>
