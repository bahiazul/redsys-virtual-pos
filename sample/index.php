<?php

date_default_timezone_set('Europe/Madrid');

require_once __DIR__ . '/../vendor/autoload.php';

use nkm\RedsysVirtualPos\Environment\TestEnvironment;
use nkm\RedsysVirtualPos\Message\WebRequest;
use nkm\RedsysVirtualPos\Message\WebResponse;
use nkm\RedsysVirtualPos\Field\Currency;

$env = new nkm\RedsysVirtualPos\Environment\TestEnvironment();
$env->setSecret('qwertyasdf0123456789');

$webRequest = new WebRequest($env);
$webRequest->setParams([
    'amount'             => '24995',
    'currency'           => Currency::EUR,
    'merchantcode'       => '327234688',
    'merchantname'       => 'Comercio en pruebas',
    'order'              => '141020090000',
    'productdescription' => 'Descripción del producto',
    'terminal'           => '1',
    'merchanturl'        => 'https://example.com/redsys/receiver',
    'urlok'              => 'https://example.com/order/checkout/confirmation.html',
    'urlko'              => 'https://example.com/order/checkout/failure.html',
]);

$submitBtn = "<input type='submit' name='submit' value='Submit'>";

var_dump($webRequest->getIsValid());
var_dump($webRequest->getValidationErrors());

$webResponse = new WebResponse($env);
$webResponse->setParams([
    'ds_transactiontype'   => '0',
    'ds_card_country'      => '280',
    'ds_date'              => '20/10/2014',
    'ds_securepayment'     => '1',
    'ds_signature'         => '7D9FB1CA60B10FB6A5B7CE883EA3C8A1F8015D3B',
    'ds_order'             => '141020090000',
    'ds_hour'              => '09:00',
    'ds_response'          => '0000',
    'ds_authorisationcode' => '123456',
    'ds_currency'          => '978',
    'ds_consumerlanguage'  => '5',
    'ds_merchantcode'      => '327234688',
    'ds_amount'            => '24995',
    'ds_terminal'          => '001',
]);

var_dump($webResponse->getIsValid());
var_dump($webResponse->getValidationErrors());

?>
<html>
    <body>
        <?php echo $webRequest->getForm([], $submitBtn); ?>
    </body>
</html>
