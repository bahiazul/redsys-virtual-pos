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
     * @var array
     */
    protected $fields = [
        'Ds_Date'              => 'Date',
        'Ds_Hour'              => 'Hour',
        'Ds_Amount'            => 'Amount',
        'Ds_Currency'          => 'Currency',
        'Ds_Order'             => 'Order',
        'Ds_MerchantCode'      => 'MerchantCode',
        'Ds_Terminal'          => 'Terminal',
        'Ds_Signature'         => 'Signature',
        'Ds_Response'          => 'Response',
        'Ds_TransactionType'   => 'TransactionType',
        'Ds_SecurePayment'     => 'SecurePayment',
        'Ds_MerchantData'      => 'MerchantData',
        'Ds_Card_Country'      => 'CardCountry',
        'Ds_AuthorisationCode' => 'AuthorisationCode',
        'Ds_ConsumerLanguage'  => 'ConsumerLanguage',
        'Ds_Card_Type'         => 'CardType',
        'Ds_ErrorCode'         => 'ErrorCode',
    ];

    /**
     * Fields that comprise the signature
     * @var array
     */
    protected $signatureFields = [
        'Ds_Amount',
        'Ds_Order',
        'Ds_MerchantCode',
        'Ds_Currency',
        'Ds_Response',
    ];

    /**
     * Validates all the params of the request
     * @return MessageInterface
     */
    protected function validate()
    {
        $isValid = true;
        $validationErrors = [];

        $responseSignature = $this->getParam('Ds_Signature');
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
