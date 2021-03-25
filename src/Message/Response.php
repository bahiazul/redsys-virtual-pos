<?php
/**
 * Redsys Virtual POS
 *
 * @package    Redsys Virtual POS
 * @author     Javier Zapata <javierzapata82@gmail.com>
 * @copyright  2021 Javier Zapata <javierzapata82@gmail.com>
 * @license    https://opensource.org/licenses/MIT The MIT License
 * @link       https://github.com/jzfgo/redsys-virtual-pos
 */

namespace nkm\RedsysVirtualPos\Message;

/**
 * Part of a communication for a monetary operation (a request or a reponse)
 *
 * @package    Redsys Virtual POS
 * @author     Javier Zapata <javierzapata82@gmail.com>
 * @copyright  2021 Javier Zapata <javierzapata82@gmail.com>
 * @license    https://opensource.org/licenses/MIT The MIT License
 * @link       https://github.com/jzfgo/redsys-virtual-pos
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
        'Amount',
        'AuthorisationCode',
        'Card_Brand',
        'Card_Country',
        'Card_Number',
        'Card_Type',
        'CardNumber',
        'ConsumerLanguage',
        'Currency',
        'Date',
        'DCC',
        'ErrorCode',
        'ExpiryDate',
        'Hour',
        'Merchant_Cof_Txnid',
        'Merchant_Identifier',
        'MerchantCode',
        'MerchantData',
        'MerchantParameters',
        'MerchantPartialPayment',
        'Order',
        'ProcessedPayMethod',
        'Reference',
        'Response',
        'SecurePayment',
        'Signature',
        'SignatureVersion',
        'Terminal',
        'Titular',
        'TransactionType',
        'UrlPago2Fases',
    ];

    /**
     * Validates all the params of the request
     * @return MessageInterface
     */
    protected function validate()
    {
        $this->isValid = true;
        $this->validationErrors = [];

        return $this;
    }
}
