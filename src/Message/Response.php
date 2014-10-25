<?php
/**
 * Redsys Virtual POS
 *
 * @package    Redsys Virtual POS
 * @author     Javier Zapata <javierzapata82@gmail.com>
 * @copyright  2014 Javier Zapata <javierzapata82@gmail.com>
 * @license    http://www.opensource.org/licenses/BSD-3-Clause  The BSD 3-Clause License
 * @link       http://github.com/nkm/redsys-virtual-pos
 */

namespace nkm\RedsysVirtualPos\Message;

/**
 * Part of a communication for a monetary operation (a request or a reponse)
 *
 * @package    Redsys Virtual POS
 * @author     Javier Zapata <javierzapata82@gmail.com>
 * @copyright  2014 Javier Zapata <javierzapata82@gmail.com>
 * @license    http://www.opensource.org/licenses/BSD-3-Clause  The BSD 3-Clause License
 * @link       http://github.com/nkm/redsys-virtual-pos
 */
class Response extends AbstractMessage implements MessageInterface
{
    /**
     * All the fields that can go in a response
     *
     * The array's keys should be underscore strings
     * and its values be names of classes extending
     * from AbstractField
     *
     * @var array
     */
    protected $fields = [
        'ds_date'              => 'Date',
        'ds_hour'              => 'Hour',
        'ds_amount'            => 'Amount',
        'ds_currency'          => 'Currency',
        'ds_order'             => 'Order',
        'ds_merchantcode'      => 'MerchantCode',
        'ds_terminal'          => 'Terminal',
        'ds_signature'         => 'Signature',
        'ds_response'          => 'Response',
        'ds_transactiontype'   => 'TransactionType',
        'ds_securepayment'     => 'SecurePayment',
        'ds_merchantdata'      => 'MerchantData',
        'ds_card_country'      => 'CardCountry',
        'ds_authorisationcode' => 'AuthorisationCode',
        'ds_consumerlanguage'  => 'ConsumerLanguage',
        'ds_card_type'         => 'CardType',
        'ds_errorcode'         => 'ErrorCode',
    ];

    /**
     * Fields that comprise the signature
     * @var array
     */
    protected $signatureFields = [
        'ds_amount',
        'ds_order',
        'ds_merchantcode',
        'ds_currency',
        'ds_response',
    ];

    /**
     * Validates all the params of the request
     * @return MessageInterface
     */
    protected function validate()
    {
        $isValid = true;
        $validationErrors = [];

        $responseSignature = $this->getParam('ds_signature');
        $checkSignature    = $this->generateSignature();

        if ($responseSignature->getValue() !== $checkSignature) {
            $isValid = false;
            $validationErrors[] = 'La firma recibida no es correcta.';
        }

        $this->isValid          = $isValid;
        $this->validationErrors = $validationErrors;

        return $this;
    }
}
