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

namespace nkm\RedsysVirtualPos\Field;

/**
 * Holds the value of a request/response parameter
 *
 * @package    Redsys Virtual POS
 * @author     Javier Zapata <javierzapata82@gmail.com>
 * @copyright  2014 Javier Zapata <javierzapata82@gmail.com>
 * @license    http://www.opensource.org/licenses/BSD-3-Clause  The BSD 3-Clause License
 * @link       http://github.com/nkm/redsys-virtual-pos
 */
class ErrorCode extends AbstractField implements FieldInterface
{

    protected $name         = 'ErrorCode';
    protected $responseName = 'Ds_ErrorCode';

    const MSG_SYSTEM_BUSY                      = 'MSG0000';
    const MSG_ORDER_NUMBER_REPEATED            = 'MSG0001';
    const MSG_CARD_PIN_NOT_REGISTERED          = 'MSG0002';
    const MSG_SYSTEM_NOT_READY                 = 'MSG0003';
    const MSG_AUTH_ERROR                       = 'MSG0004';
    const MSG_CARD_NO_PAYMENT_METHOD_AVAILABLE = 'MSG0005';
    const MSG_CARD_NOT_ON_SERVICE              = 'MSG0006';
    const MSG_DATA_MISSING                     = 'MSG0007';
    const MSG_DATA_SENT_ERROR                  = 'MSG0008';

    /**
     * Holds every kind of error
     * @var array
     */
    private static $messages = [
        self::MSG_SYSTEM_BUSY                      => 'System occupied, try later',
        self::MSG_ORDER_NUMBER_REPEATED            => 'Repeated order number',
        self::MSG_CARD_PIN_NOT_REGISTERED          => 'Card Pin not registered on FINANET',
        self::MSG_SYSTEM_NOT_READY                 => 'System launching, try again in a few moments',
        self::MSG_AUTH_ERROR                       => 'Authentication Error',
        self::MSG_CARD_NO_PAYMENT_METHOD_AVAILABLE => 'No valid payment method exists for your card',
        self::MSG_CARD_NOT_ON_SERVICE              => 'Non-SERVICE CARD',
        self::MSG_DATA_MISSING                     => 'Data missing, please check your browser accepts cookies',
        self::MSG_DATA_SENT_ERROR                  => 'Error in data sent. Contact your merchant',
    ];

    /**
     * @var array
     */
    private static $errors = [
        'SIS0007' => [
            'reason'  => "Error disassembling input XML",
            'message' => self::MSG_DATA_SENT_ERROR,
        ],

        'SIS0008' => [
            'field'   => 'Ds_Merchant_MerchantCode',
            'reason'  => 'Field missing',
            'message' => self::MSG_DATA_SENT_ERROR,
        ],

        'SIS0009' => [
            'field'   => 'Ds_Merchant_MerchantCode',
            'reason'  => 'Format error',
            'message' => self::MSG_DATA_SENT_ERROR,
        ],

        'SIS0010' => [
            'field'   => 'Ds_Merchant_Terminal',
            'reason'  => 'Field missing',
            'message' => self::MSG_DATA_SENT_ERROR,
        ],

        'SIS0011' => [
            'field'   => 'Ds_Merchant_Terminal',
            'reason'  => 'Format error',
            'message' => self::MSG_DATA_SENT_ERROR,
        ],

        'SIS0014' => [
            'field'   => 'Ds_Merchant_Order',
            'reason'  => 'Format error',
            'message' => self::MSG_DATA_SENT_ERROR,
        ],

        'SIS0015' => [
            'field'   => 'Ds_Merchant_Currency',
            'reason'  => 'Field missing',
            'message' => self::MSG_DATA_SENT_ERROR,
        ],

        'SIS0016' => [
            'field'   => 'Ds_Merchant_Currency',
            'reason'  => 'Format error',
            'message' => self::MSG_DATA_SENT_ERROR,
        ],

        'SIS0018' => [
            'field'   => 'Ds_Merchant_Amount',
            'reason'  => 'Field missing',
            'message' => self::MSG_DATA_SENT_ERROR,
        ],

        'SIS0019' => [
            'field'   => 'Ds_Merchant_Amount',
            'reason'  => 'Format error',
            'message' => self::MSG_DATA_SENT_ERROR,
        ],

        'SIS0020' => [
            'field'   => 'Ds_Merchant_Signature',
            'reason'  => 'Field missing',
            'message' => self::MSG_DATA_SENT_ERROR,
        ],

        'SIS0021' => [
            'field'   => 'Ds_Merchant_Signature',
            'reason'  => 'Field empty',
            'message' => self::MSG_DATA_SENT_ERROR,
        ],

        'SIS0022' => [
            'field'   => 'Ds_TransactionType',
            'reason'  => 'Format error',
            'message' => self::MSG_DATA_SENT_ERROR,
        ],

        'SIS0023' => [
            'field'   => 'Ds_TransactionType',
            'reason'  => 'Unknown value',
            'message' => self::MSG_DATA_SENT_ERROR,
        ],

        'SIS0024' => [
            'field'   => 'Ds_ConsumerLanguage',
            'reason'  => 'Value exceeds 3 positions',
            'message' => self::MSG_DATA_SENT_ERROR,
        ],

        'SIS0025' => [
            'field'   => 'Ds_ConsumerLanguage',
            'reason'  => 'Format error',
            'message' => self::MSG_DATA_SENT_ERROR,
        ],

        'SIS0026' => [
            'field'   => 'Ds_Merchant_MerchantCode',
            'reason'  => 'Error Merchant inexistent / Terminal sent',
            'message' => self::MSG_DATA_SENT_ERROR,
        ],

        'SIS0027' => [
            'field'   => 'Ds_Merchant_Currency',
            'reason'  => 'Error currency does not match that assigned for that Terminal.',
            'message' => self::MSG_DATA_SENT_ERROR,
        ],

        'SIS0028' => [
            'field'   => 'Ds_Merchant_MerchantCode',
            'reason'  => 'Error Merchant/Terminal is de-registered',
            'message' => self::MSG_DATA_SENT_ERROR,
        ],

        'SIS0030' => [
            'field'   => 'Ds_TransactionType',
            'reason'  => 'In card payment a type of operation has arrived which is not payment nor pre-authorisation',
            'message' => self::MSG_SYSTEM_BUSY,
        ],

        'SIS0031' => [
            'field'   => 'Ds_Merchant_TransactionType',
            'reason'  => 'Method of payment not defined',
            'message' => self::MSG_SYSTEM_BUSY,
        ],

        'SIS0034' => [
            'reason'  => 'Error accessing database',
            'message' => self::MSG_SYSTEM_BUSY,
        ],

        'SIS0038' => [
            'reason'  => 'Error in JAVA',
            'message' => self::MSG_SYSTEM_BUSY,
        ],

        'SIS0040' => [
            'reason'  => 'The merchant / Terminal has not assigned method of payment',
            'message' => self::MSG_DATA_SENT_ERROR,
        ],

        'SIS0041' => [
            'field'   => 'Ds_Merchant_Signature',
            'reason'  => 'Error calculating HASH algorithm',
            'message' => self::MSG_DATA_SENT_ERROR,
        ],

        'SIS0042' => [
            'field'   => 'Ds_Merchant_Signature',
            'reason'  => 'Error calculating HASH algorithm',
            'message' => self::MSG_DATA_SENT_ERROR,
        ],

        'SIS0043' => [
            'reason'  => 'Error making online notification',
            'message' => self::MSG_DATA_SENT_ERROR,
        ],

        'SIS0046' => [
            'reason'  => 'Card BIN (the first four digits of the card number) not registered',
            'message' => self::MSG_CARD_PIN_NOT_REGISTERED,
        ],

        'SIS0051' => [
            'field'   => 'Ds_Merchant_Order',
            'reason'  => 'Repeated order number',
            'message' => self::MSG_ORDER_NUMBER_REPEATED,
        ],

        'SIS0054' => [
            'field'   => 'Ds_Merchant_Order',
            'reason'  => 'No operation to make refund',
            'message' => self::MSG_DATA_SENT_ERROR,
        ],

        'SIS0055' => [
            'field'   => 'Ds_Merchant_Order',
            'reason'  => 'Operation to be refunded is not valid',
            'message' => self::MSG_DATA_SENT_ERROR,
        ],

        'SIS0056' => [
            'field'   => 'Ds_Merchant_Order',
            'reason'  => 'Operation to be refunded is not authorised',
            'message' => self::MSG_DATA_SENT_ERROR,
        ],

        'SIS0057' => [
            'field'   => 'Ds_Merchant_Amount',
            'reason'  => 'Amount to be refunded exceeds limit',
            'message' => self::MSG_DATA_SENT_ERROR,
        ],

        'SIS0058' => [
            'reason'  => 'Inconsistent data in validation of confirmation',
            'message' => self::MSG_DATA_SENT_ERROR,
        ],

        'SIS0059' => [
            'field'   => 'Ds_Merchant_Order',
            'reason'  => 'Error, operation for confirmation does not exist',
            'message' => self::MSG_DATA_SENT_ERROR,
        ],

        'SIS0060' => [
            'field'   => 'Ds_Merchant_Order',
            'reason'  => 'Confirmation for this pre-authorisation already exists',
            'message' => self::MSG_DATA_SENT_ERROR,
        ],

        'SIS0061' => [
            'field'   => 'Ds_Merchant_Order',
            'reason'  => 'The pre-authorisation to be confirmed is not authorised',
            'message' => self::MSG_DATA_SENT_ERROR,
        ],

        'SIS0062' => [
            'field'   => 'Ds_Merchant_Amount',
            'reason'  => 'Amount to be confirmed exceeds limit',
            'message' => self::MSG_DATA_SENT_ERROR,
        ],

        'SIS0063' => [
            'reason'  => 'Error in card number',
            'message' => self::MSG_DATA_SENT_ERROR,
        ],

        'SIS0064' => [
            'reason'  => 'Error in card number',
            'message' => self::MSG_DATA_SENT_ERROR,
        ],

        'SIS0065' => [
            'reason'  => 'Error in card number',
            'message' => self::MSG_DATA_SENT_ERROR,
        ],

        'SIS0066' => [
            'reason'  => 'Error in card expiry date',
            'message' => self::MSG_DATA_SENT_ERROR,
        ],

        'SIS0067' => [
            'reason'  => 'Error in card expiry date',
            'message' => self::MSG_DATA_SENT_ERROR,
        ],

        'SIS0068' => [
            'reason'  => 'Error in card expiry date',
            'message' => self::MSG_DATA_SENT_ERROR,
        ],

        'SIS0069' => [
            'reason'  => 'Error in card expiry date',
            'message' => self::MSG_DATA_SENT_ERROR,
        ],

        'SIS0070' => [
            'reason'  => 'Error in card expiry date',
            'message' => self::MSG_DATA_SENT_ERROR,
        ],

        'SIS0071' => [
            'reason'  => 'Expired CARD',
            'message' => self::MSG_SYSTEM_BUSY,
        ],

        'SIS0072' => [
            'field'   => 'Ds_Merchant_Order',
            'reason'  => 'Operation cannot be cancelled',
            'message' => self::MSG_SYSTEM_BUSY,
        ],

        'SIS0074' => [
            'field'   => 'Ds_Merchant_Order',
            'reason'  => 'Field missing',
            'message' => self::MSG_DATA_SENT_ERROR,
        ],

        'SIS0075' => [
            'field'   => 'Ds_Merchant_Order',
            'reason'  => 'Value has fewer than 4 positions or more than 12',
            'message' => self::MSG_DATA_SENT_ERROR,
        ],

        'SIS0076' => [
            'field'   => 'Ds_Merchant_Order',
            'reason'  => 'Value is not numerical',
            'message' => self::MSG_DATA_SENT_ERROR,
        ],

        'SIS0078' => [
            'field'   => 'Ds_TransactionType',
            'reason'  => 'Unknown value',
            'message' => self::MSG_CARD_NO_PAYMENT_METHOD_AVAILABLE,
        ],

        'SIS0093' => [
            'reason'  => 'Card not found within table of ranges',
            'message' => self::MSG_CARD_NOT_ON_SERVICE,
        ],

        'SIS0094' => [
            'reason'  => 'Card not authenticated as 3D Secure',
            'message' => self::MSG_AUTH_ERROR,
        ],

        'SIS0112' => [
            'field'   => 'Ds_TransactionType',
            'reason'  => 'Value not allowed',
            'message' => self::MSG_DATA_SENT_ERROR,
        ],

        'SIS0114' => [
            'reason'  => 'A GET has been called instead of a POST',
            'message' => self::MSG_SYSTEM_BUSY,
        ],

        'SIS0115' => [
            'field'   => 'Ds_Merchant_Order',
            'reason'  => 'No operation to make instalment payment',
            'message' => self::MSG_DATA_SENT_ERROR,
        ],

        'SIS0116' => [
            'field'   => 'Ds_Merchant_Order',
            'reason'  => 'Operation for instalment payment is not valid.',
            'message' => self::MSG_DATA_SENT_ERROR,
        ],

        'SIS0117' => [
            'field'   => 'Ds_Merchant_Order',
            'reason'  => 'Operation for instalment payment is not authorised.',
            'message' => self::MSG_DATA_SENT_ERROR,
        ],

        'SIS0132' => [
            'reason'  => 'The Confirmation of Authorisation date cannot exceed pre-authorisation date by more than 7 days',
            'message' => self::MSG_DATA_SENT_ERROR,
        ],

        'SIS0133' => [
            'reason'  => 'The confirmation of Authentication date cannot exceed prior authentication by more than 45 days',
            'message' => self::MSG_DATA_SENT_ERROR,
        ],

        'SIS0139' => [
            'reason'  => 'Initial recurrent payment is duplicated',
            'message' => self::MSG_DATA_SENT_ERROR,
        ],

        'SIS0142' => [
            'reason'  => 'Time exceeded for payment',
            'message' => self::MSG_SYSTEM_BUSY,
        ],

        'SIS0198' => [
            'reason'  => 'Amount exceeds limit allowed for merchant',
            'message' => self::MSG_DATA_SENT_ERROR,
        ],

        'SIS0199' => [
            'reason'  => 'The number of operations exceeds limit allowed for merchant',
            'message' => self::MSG_DATA_SENT_ERROR,
        ],

        'SIS0200' => [
            'reason'  => 'Amount accumulated exceeds limit allowed for merchant',
            'message' => self::MSG_DATA_SENT_ERROR,
        ],

        'SIS0214' => [
            'reason'  => 'Merchant does not accept refunds',
            'message' => self::MSG_DATA_SENT_ERROR,
        ],

        'SIS0216' => [
            'reason'  => 'The CVV2 has more than three positions',
            'message' => self::MSG_DATA_SENT_ERROR,
        ],

        'SIS0217' => [
            'reason'  => 'Format error in CVV2',
            'message' => self::MSG_DATA_SENT_ERROR,
        ],

        'SIS0218' => [
            'reason'  => '“Operations” input does not allow secure payments',
            'message' => self::MSG_DATA_SENT_ERROR,
        ],

        'SIS0219' => [
            'reason'  => 'The number of card operations exceeds limit allowed for merchant',
            'message' => self::MSG_DATA_SENT_ERROR,
        ],

        'SIS0220' => [
            'reason'  => 'Accumulated amount of card exceeds limit allowed for merchant',
            'message' => self::MSG_DATA_SENT_ERROR,
        ],

        'SIS0221' => [
            'reason'  => 'Error. The CVV2 is required:',
            'message' => self::MSG_DATA_SENT_ERROR,
        ],

        'SIS0222' => [
            'reason'  => 'Cancellation for this pre-authorisation already exists',
            'message' => self::MSG_DATA_SENT_ERROR,
        ],

        'SIS0223' => [
            'reason'  => 'The pre-authorisation to be cancelled is not authorised',
            'message' => self::MSG_DATA_SENT_ERROR,
        ],

        'SIS0224' => [
            'reason'  => 'Merchant does not allow cancellations due to lack of extended signature',
            'message' => self::MSG_DATA_SENT_ERROR,
        ],

        'SIS0225' => [
            'reason'  => 'No operation to make cancellation',
            'message' => self::MSG_DATA_SENT_ERROR,
        ],

        'SIS0226' => [
            'reason'  => 'Inconsistent data in validation of a cancellation',
            'message' => self::MSG_DATA_SENT_ERROR,
        ],

        'SIS0227' => [
            'field'   => 'Ds_Merchant_TransactionDate',
            'reason'  => 'Invalid value',
            'message' => self::MSG_DATA_SENT_ERROR,
        ],

        'SIS0229' => [
            'reason'  => 'No deferred payment code requested',
            'message' => self::MSG_DATA_SENT_ERROR,
        ],

        'SIS0252' => [
            'reason'  => 'Merchant does not allow card to be sent',
            'message' => self::MSG_DATA_SENT_ERROR,
        ],

        'SIS0253' => [
            'reason'  => 'Card does not comply with check-digit',
            'message' => self::MSG_DATA_SENT_ERROR,
        ],

        'SIS0254' => [
            'reason'  => 'The number of operations per IP exceeds limit allowed for merchant',
            'message' => self::MSG_DATA_SENT_ERROR,
        ],

        'SIS0255' => [
            'reason'  => 'Amount accumulated per IP exceeds limit allowed for merchant',
            'message' => self::MSG_DATA_SENT_ERROR,
        ],

        'SIS0256' => [
            'reason'  => 'Merchant cannot perform pre-authorisations.',
            'message' => self::MSG_DATA_SENT_ERROR,
        ],

        'SIS0257' => [
            'reason'  => 'Card does not allow pre-authorisations',
            'message' => self::MSG_DATA_SENT_ERROR,
        ],

        'SIS0258' => [
            'reason'  => 'Inconsistent confirmation data',
            'message' => self::MSG_DATA_SENT_ERROR,
        ],

        'SIS0261' => [
            'reason'  => 'Operation exceeds an operating limit defined by Banco Sabadell',
            'message' => self::MSG_DATA_SENT_ERROR,
        ],

        'SIS0270' => [
            'field'   => 'Ds_Merchant_TransactionType',
            'reason'  => 'Type of operation not activated for this merchant',
            'message' => self::MSG_DATA_SENT_ERROR,
        ],

        'SIS0274' => [
            'field'   => 'Ds_Merchant_TransactionType',
            'reason'  => 'Type of operation unknown or not allowed for this input to the SIS.',
            'message' => self::MSG_DATA_SENT_ERROR,
        ],

        'SIS0281' => [
            'reason'  => 'Operation exceeds an operating limit defined by Banco Sabadell',
            'message' => self::MSG_DATA_SENT_ERROR,
        ],

        'SIS0296' => [
            'reason'  => 'Error validating initial operation data “Card on File (Subscriptions P./Express P)”.',
            'message' => self::MSG_DATA_SENT_ERROR,
        ],

        'SIS0297' => [
            'reason'  => 'Maximum number of operations exceeded (99 oper. or 1 year) for successive transactions in “Card on File (Subscriptions P. /Express P.)”. A new “Initial File Card” operation is necessary to start the cycle.',
            'message' => self::MSG_DATA_SENT_ERROR,
        ],

        'SIS0298' => [
            'reason'  => 'Merchant not configured to make “Card on File (Subscriptions/Express P.)”',
            'message' => self::MSG_DATA_SENT_ERROR,
        ],
    ];

    /**
     * @return array
     */
    private static function getErrors()
    {
        return (array) self::$errors;
    }

    /**
     * @param  string  $code The error code
     * @return boolean
     */
    private static function hasError($code)
    {
        $errors = self::getErrors();

        return array_key_exists($code, $errors);
    }

    /**
     * @param  string $code
     * @return array|null The error info or null if not found
     */
    private static function getError($code)
    {
        if (self::hasError($code)) {
            $errors = self::getErrors();

            return $errors[$code];
        }

        return null;
    }

    /**
     * @return array
     */
    private static function getMessages()
    {
        return (array) self::$messages;
    }

    /**
     * @return string The name of the affected field (optional)
     */
    public function getField()
    {
        $this->ensureValidCode($this->value);
        $errors = self::getErrors();

        if (isset($errors[$this->value]['field'])) {
            return $errors[$this->value]['field'];
        }

        return null;
    }

    /**
     * @return string The reason for the error
     */
    public function getReason()
    {
        $this->ensureValidCode($this->value);
        $errors = self::getErrors();

        return $errors[$this->value]['reason'];
    }

    /**
     * @return string The message shown to the end-user
     */
    public function getMessage()
    {
        $this->ensureValidCode($this->value);
        $errors = self::getErrors();

        $messageKey = $errors[$this->value]['message'];
        $messages   = self::getMessages();

        return $messages[$messageKey];
    }

    /**
     * @param  string $code The error code
     * @throws Exception If the code is not valid
     */
    private static function ensureValidCode($code)
    {
        if (is_null($code)) {
            throw new FieldException("Error code is not defined.");
        }

        if (is_null(self::getError($code))) {
            throw new FieldException("Invalid Error code.");
        }
    }
}
