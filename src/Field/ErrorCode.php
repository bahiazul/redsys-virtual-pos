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
        self::MSG_SYSTEM_BUSY                      => 'El sistema está ocupado, inténtelo más tarde',
        self::MSG_ORDER_NUMBER_REPEATED            => 'Número de pedido repetido',
        self::MSG_CARD_PIN_NOT_REGISTERED          => 'El BIN de la tarjeta no está dado de alta en FINANET',
        self::MSG_SYSTEM_NOT_READY                 => 'El sistema está arrancando, inténtelo en unos momentos',
        self::MSG_AUTH_ERROR                       => 'Error de Autenticación',
        self::MSG_CARD_NO_PAYMENT_METHOD_AVAILABLE => 'No existe método de pago válido para su tarjeta',
        self::MSG_CARD_NOT_ON_SERVICE              => 'Tarjeta ajena al servicio',
        self::MSG_DATA_MISSING                     => 'Faltan datos, por favor compruebe que su navegador acepta cookies',
        self::MSG_DATA_SENT_ERROR                  => 'Error en datos enviados. Contacte con su comercio',
    ];

    /**
     * @var array
     */
    private static $errors = [
        'SIS0007' => [
            'reason'  => "Error al desmontar XML de entrada",
            'message' => self::MSG_DATA_SENT_ERROR,
        ],

        'SIS0008' => [
            'field'   => 'Ds_Merchant_MerchantCode',
            'reason'  => 'Falta el campo',
            'message' => self::MSG_DATA_SENT_ERROR,
        ],

        'SIS0009' => [
            'field'   => 'Ds_Merchant_MerchantCode',
            'reason'  => 'Error de formato',
            'message' => self::MSG_DATA_SENT_ERROR,
        ],

        'SIS0010' => [
            'field'   => 'Ds_Merchant_Terminal',
            'reason'  => 'Falta el campo',
            'message' => self::MSG_DATA_SENT_ERROR,
        ],

        'SIS0011' => [
            'field'   => 'Ds_Merchant_Terminal',
            'reason'  => 'Error de formato',
            'message' => self::MSG_DATA_SENT_ERROR,
        ],

        'SIS0014' => [
            'field'   => 'Ds_Merchant_Order',
            'reason'  => 'Error de formato',
            'message' => self::MSG_DATA_SENT_ERROR,
        ],

        'SIS0015' => [
            'field'   => 'Ds_Merchant_Currency',
            'reason'  => 'Falta el campo',
            'message' => self::MSG_DATA_SENT_ERROR,
        ],

        'SIS0016' => [
            'field'   => 'Ds_Merchant_Currency',
            'reason'  => 'Error de formato',
            'message' => self::MSG_DATA_SENT_ERROR,
        ],

        'SIS0018' => [
            'field'   => 'Ds_Merchant_Amount',
            'reason'  => 'Falta el campo',
            'message' => self::MSG_DATA_SENT_ERROR,
        ],

        'SIS0019' => [
            'field'   => 'Ds_Merchant_Amount',
            'reason'  => 'Error de formato',
            'message' => self::MSG_DATA_SENT_ERROR,
        ],

        'SIS0020' => [
            'field'   => 'Ds_Merchant_Signature',
            'reason'  => 'Falta el campo',
            'message' => self::MSG_DATA_SENT_ERROR,
        ],

        'SIS0021' => [
            'field'   => 'Ds_Merchant_Signature',
            'reason'  => 'Campo sin datos',
            'message' => self::MSG_DATA_SENT_ERROR,
        ],

        'SIS0022' => [
            'field'   => 'Ds_TransactionType',
            'reason'  => 'Error de formato',
            'message' => self::MSG_DATA_SENT_ERROR,
        ],

        'SIS0023' => [
            'field'   => 'Ds_TransactionType',
            'reason'  => 'Valor desconocido',
            'message' => self::MSG_DATA_SENT_ERROR,
        ],

        'SIS0024' => [
            'field'   => 'Ds_ConsumerLanguage',
            'reason'  => 'Valor excede de 3 posiciones',
            'message' => self::MSG_DATA_SENT_ERROR,
        ],

        'SIS0025' => [
            'field'   => 'Ds_ConsumerLanguage',
            'reason'  => 'Error de formato',
            'message' => self::MSG_DATA_SENT_ERROR,
        ],

        'SIS0026' => [
            'field'   => 'Ds_Merchant_MerchantCode',
            'reason'  => 'Error No existe el comercio / Terminal enviado',
            'message' => self::MSG_DATA_SENT_ERROR,
        ],

        'SIS0027' => [
            'field'   => 'Ds_Merchant_Currency',
            'reason'  => 'Error moneda no coincide con asignada para ese Terminal.',
            'message' => self::MSG_DATA_SENT_ERROR,
        ],

        'SIS0028' => [
            'field'   => 'Ds_Merchant_MerchantCode',
            'reason'  => 'Error Comercio/Terminal está dado de baja',
            'message' => self::MSG_DATA_SENT_ERROR,
        ],

        'SIS0030' => [
            'field'   => 'Ds_TransactionType',
            'reason'  => 'En un pago con tarjeta ha llegado un tipo de operación que no es ni pago ni preautoritzación',
            'message' => self::MSG_SYSTEM_BUSY,
        ],

        'SIS0031' => [
            'field'   => 'Ds_Merchant_TransactionType',
            'reason'  => 'Método de pago no definido',
            'message' => self::MSG_SYSTEM_BUSY,
        ],

        'SIS0034' => [
            'reason'  => 'Error en acceso a la Base de datos',
            'message' => self::MSG_SYSTEM_BUSY,
        ],

        'SIS0038' => [
            'reason'  => 'Error en JAVA',
            'message' => self::MSG_SYSTEM_BUSY,
        ],

        'SIS0040' => [
            'reason'  => 'El comercio / Terminal no tiene ningún método de pago asignado',
            'message' => self::MSG_DATA_SENT_ERROR,
        ],

        'SIS0041' => [
            'field'   => 'Ds_Merchant_Signature',
            'reason'  => 'Error en el cálculo del algoritmo HASH',
            'message' => self::MSG_DATA_SENT_ERROR,
        ],

        'SIS0042' => [
            'field'   => 'Ds_Merchant_Signature',
            'reason'  => 'Error en el cálculo del algoritmo HASH',
            'message' => self::MSG_DATA_SENT_ERROR,
        ],

        'SIS0043' => [
            'reason'  => 'Error al realizar la notificación online',
            'message' => self::MSG_DATA_SENT_ERROR,
        ],

        'SIS0046' => [
            'reason'  => 'El BIN (6 primeros dígitos de la tarjeta) no está dado de alta',
            'message' => self::MSG_CARD_PIN_NOT_REGISTERED,
        ],

        'SIS0051' => [
            'field'   => 'Ds_Merchant_Order',
            'reason'  => 'Número de pedido repetido',
            'message' => self::MSG_ORDER_NUMBER_REPEATED,
        ],

        'SIS0054' => [
            'field'   => 'Ds_Merchant_Order',
            'reason'  => 'No existe operación sobre la que realizar la devolución',
            'message' => self::MSG_DATA_SENT_ERROR,
        ],

        'SIS0055' => [
            'field'   => 'Ds_Merchant_Order',
            'reason'  => 'La operación sobre la que se desea realizar la devolución no es una operación válida',
            'message' => self::MSG_DATA_SENT_ERROR,
        ],

        'SIS0056' => [
            'field'   => 'Ds_Merchant_Order',
            'reason'  => 'La operación sobre la que se desea realizar la devolución no está autorizada',
            'message' => self::MSG_DATA_SENT_ERROR,
        ],

        'SIS0057' => [
            'field'   => 'Ds_Merchant_Amount',
            'reason'  => 'El importe a devolver supera el permitido',
            'message' => self::MSG_DATA_SENT_ERROR,
        ],

        'SIS0058' => [
            'reason'  => 'Inconsistencia de datos, en la validación de una confirmación',
            'message' => self::MSG_DATA_SENT_ERROR,
        ],

        'SIS0059' => [
            'field'   => 'Ds_Merchant_Order',
            'reason'  => 'Error, no existe la operación sobre la que realizar la confirmación',
            'message' => self::MSG_DATA_SENT_ERROR,
        ],

        'SIS0060' => [
            'field'   => 'Ds_Merchant_Order',
            'reason'  => 'Ya existe confirmación asociada a la preautorización',
            'message' => self::MSG_DATA_SENT_ERROR,
        ],

        'SIS0061' => [
            'field'   => 'Ds_Merchant_Order',
            'reason'  => 'La preautorización sobre la que se desea confirmar no está autorizada',
            'message' => self::MSG_DATA_SENT_ERROR,
        ],

        'SIS0062' => [
            'field'   => 'Ds_Merchant_Amount',
            'reason'  => 'El importe a confirmar supera el permitido',
            'message' => self::MSG_DATA_SENT_ERROR,
        ],

        'SIS0063' => [
            'reason'  => 'Error en número de tarjeta',
            'message' => self::MSG_DATA_SENT_ERROR,
        ],

        'SIS0064' => [
            'reason'  => 'Error en número de tarjeta',
            'message' => self::MSG_DATA_SENT_ERROR,
        ],

        'SIS0065' => [
            'reason'  => 'Error en número de tarjeta',
            'message' => self::MSG_DATA_SENT_ERROR,
        ],

        'SIS0066' => [
            'reason'  => 'Error en caducidad tarjeta',
            'message' => self::MSG_DATA_SENT_ERROR,
        ],

        'SIS0067' => [
            'reason'  => 'Error en caducidad tarjeta',
            'message' => self::MSG_DATA_SENT_ERROR,
        ],

        'SIS0068' => [
            'reason'  => 'Error en caducidad tarjeta',
            'message' => self::MSG_DATA_SENT_ERROR,
        ],

        'SIS0069' => [
            'reason'  => 'Error en caducidad tarjeta',
            'message' => self::MSG_DATA_SENT_ERROR,
        ],

        'SIS0070' => [
            'reason'  => 'Error en caducidad tarjeta',
            'message' => self::MSG_DATA_SENT_ERROR,
        ],

        'SIS0071' => [
            'reason'  => 'Tarjeta caducada',
            'message' => self::MSG_SYSTEM_BUSY,
        ],

        'SIS0072' => [
            'field'   => 'Ds_Merchant_Order',
            'reason'  => 'Operación no anulable',
            'message' => self::MSG_SYSTEM_BUSY,
        ],

        'SIS0074' => [
            'field'   => 'Ds_Merchant_Order',
            'reason'  => 'Falta el campo',
            'message' => self::MSG_DATA_SENT_ERROR,
        ],

        'SIS0075' => [
            'field'   => 'Ds_Merchant_Order',
            'reason'  => 'El valor tiene menos de 4 posiciones o más de 12',
            'message' => self::MSG_DATA_SENT_ERROR,
        ],

        'SIS0076' => [
            'field'   => 'Ds_Merchant_Order',
            'reason'  => 'El valor no es numérico',
            'message' => self::MSG_DATA_SENT_ERROR,
        ],

        'SIS0078' => [
            'field'   => 'Ds_TransactionType',
            'reason'  => 'Valor desconocido',
            'message' => self::MSG_CARD_NO_PAYMENT_METHOD_AVAILABLE,
        ],

        'SIS0093' => [
            'reason'  => 'Tarjeta no encontrada en tabla de rangos',
            'message' => self::MSG_CARD_NOT_ON_SERVICE,
        ],

        'SIS0094' => [
            'reason'  => 'La tarjeta no fue autenticada como 3D Secure',
            'message' => self::MSG_AUTH_ERROR,
        ],

        'SIS0112' => [
            'field'   => 'Ds_TransactionType',
            'reason'  => 'Valor no permitido',
            'message' => self::MSG_DATA_SENT_ERROR,
        ],

        'SIS0114' => [
            'reason'  => 'Se ha llamado con un GET en lugar de un POST',
            'message' => self::MSG_SYSTEM_BUSY,
        ],

        'SIS0115' => [
            'field'   => 'Ds_Merchant_Order',
            'reason'  => 'No existe operación sobre la que realizar el pago de la cuota',
            'message' => self::MSG_DATA_SENT_ERROR,
        ],

        'SIS0116' => [
            'field'   => 'Ds_Merchant_Order',
            'reason'  => 'La operación sobre la que se desea pagar una cuota no es válida.',
            'message' => self::MSG_DATA_SENT_ERROR,
        ],

        'SIS0117' => [
            'field'   => 'Ds_Merchant_Order',
            'reason'  => 'La operación sobre la que se desea pagar una cuota no está autorizada',
            'message' => self::MSG_DATA_SENT_ERROR,
        ],

        'SIS0132' => [
            'reason'  => 'La fecha de Confirmación de Autorización no puede superar en más de 7 días a la preautorización',
            'message' => self::MSG_DATA_SENT_ERROR,
        ],

        'SIS0133' => [
            'reason'  => 'La fecha de confirmación de Autenticación no puede superar en más de 45 días la autenticación previa',
            'message' => self::MSG_DATA_SENT_ERROR,
        ],

        'SIS0139' => [
            'reason'  => 'El pago recurrente inicial está duplicado',
            'message' => self::MSG_DATA_SENT_ERROR,
        ],

        'SIS0142' => [
            'reason'  => 'Tiempo excedido para el pago',
            'message' => self::MSG_SYSTEM_BUSY,
        ],

        'SIS0198' => [
            'reason'  => 'Importe supera límite permitido para el comercio',
            'message' => self::MSG_DATA_SENT_ERROR,
        ],

        'SIS0199' => [
            'reason'  => 'El número de operaciones supera el límite permitido para el comercio',
            'message' => self::MSG_DATA_SENT_ERROR,
        ],

        'SIS0200' => [
            'reason'  => 'El importe acumulado supera el límite permitido para el comercio',
            'message' => self::MSG_DATA_SENT_ERROR,
        ],

        'SIS0214' => [
            'reason'  => 'El comercio no admite devoluciones',
            'message' => self::MSG_DATA_SENT_ERROR,
        ],

        'SIS0216' => [
            'reason'  => 'El CVV2 tiene más de tres posiciones',
            'message' => self::MSG_DATA_SENT_ERROR,
        ],

        'SIS0217' => [
            'reason'  => 'Error de formato en CVV2',
            'message' => self::MSG_DATA_SENT_ERROR,
        ],

        'SIS0218' => [
            'reason'  => 'La entrada “Operaciones” no permite pagos seguros',
            'message' => self::MSG_DATA_SENT_ERROR,
        ],

        'SIS0219' => [
            'reason'  => 'El número de operaciones de la tarjeta supera el límite permitido para el comercio',
            'message' => self::MSG_DATA_SENT_ERROR,
        ],

        'SIS0220' => [
            'reason'  => 'El importe acumulado de la tarjeta supera el límite permitido para el comercio',
            'message' => self::MSG_DATA_SENT_ERROR,
        ],

        'SIS0221' => [
            'reason'  => 'Error. El CVV2 es obligatorio',
            'message' => self::MSG_DATA_SENT_ERROR,
        ],

        'SIS0222' => [
            'reason'  => 'Ya existe anulación asociada a la preautorización',
            'message' => self::MSG_DATA_SENT_ERROR,
        ],

        'SIS0223' => [
            'reason'  => 'La preautorización que se desea anular no está autorizada',
            'message' => self::MSG_DATA_SENT_ERROR,
        ],

        'SIS0224' => [
            'reason'  => 'El comercio no permite anulaciones por no tener firma ampliada',
            'message' => self::MSG_DATA_SENT_ERROR,
        ],

        'SIS0225' => [
            'reason'  => 'No existe operación sobre la que realizar la anulación',
            'message' => self::MSG_DATA_SENT_ERROR,
        ],

        'SIS0226' => [
            'reason'  => 'Inconsistencia de datos en la validación de una anulación',
            'message' => self::MSG_DATA_SENT_ERROR,
        ],

        'SIS0227' => [
            'field'   => 'Ds_Merchant_TransactionDate',
            'reason'  => 'Valor no válido',
            'message' => self::MSG_DATA_SENT_ERROR,
        ],

        'SIS0229' => [
            'reason'  => 'No existe el código de pago aplazado solicitado',
            'message' => self::MSG_DATA_SENT_ERROR,
        ],

        'SIS0252' => [
            'reason'  => 'El comercio no permite el envío de tarjeta',
            'message' => self::MSG_DATA_SENT_ERROR,
        ],

        'SIS0253' => [
            'reason'  => 'La tarjeta no cumple el check-digit',
            'message' => self::MSG_DATA_SENT_ERROR,
        ],

        'SIS0254' => [
            'reason'  => 'El número de operaciones por IP supera el máximo permitido para el comercio',
            'message' => self::MSG_DATA_SENT_ERROR,
        ],

        'SIS0255' => [
            'reason'  => 'El importe acumulado por IP supera el límite permitido para el comercio',
            'message' => self::MSG_DATA_SENT_ERROR,
        ],

        'SIS0256' => [
            'reason'  => 'El comercio no puede realizar preautorizaciones',
            'message' => self::MSG_DATA_SENT_ERROR,
        ],

        'SIS0257' => [
            'reason'  => 'La tarjeta no permite preautorizaciones',
            'message' => self::MSG_DATA_SENT_ERROR,
        ],

        'SIS0258' => [
            'reason'  => 'Inconsistencia en datos de confirmación',
            'message' => self::MSG_DATA_SENT_ERROR,
        ],

        'SIS0261' => [
            'reason'  => 'Operación supera alguna limitación de operatoria definida por Banco Sabadell',
            'message' => self::MSG_DATA_SENT_ERROR,
        ],

        'SIS0270' => [
            'field'   => 'Ds_Merchant_TransactionType',
            'reason'  => 'Tipo de operación no activado para este comercio',
            'message' => self::MSG_DATA_SENT_ERROR,
        ],

        'SIS0274' => [
            'field'   => 'Ds_Merchant_TransactionType',
            'reason'  => 'Tipo de operación desconocida o no permitida para esta entrada al TPV Virtual.',
            'message' => self::MSG_DATA_SENT_ERROR,
        ],

        'SIS0281' => [
            'reason'  => 'Operación supera alguna limitación de operatoria definida por Banco Sabadell.',
            'message' => self::MSG_DATA_SENT_ERROR,
        ],

        'SIS0296' => [
            'reason'  => 'Error al validar los datos de la operación “Tarjeta en Archivo (P.Suscripciones/P.Exprés)” inicial.',
            'message' => self::MSG_DATA_SENT_ERROR,
        ],

        'SIS0297' => [
            'reason'  => 'Superado el número máximo de operaciones (99 oper. o 1 año) para realizar transacciones sucesivas de “Tarjeta en Archivo (P.Suscripciones/P.Exprés)”. Se requiere realizar una nueva operación de “Tarjeta en Archivo Inicial” para iniciar el ciclo..',
            'message' => self::MSG_DATA_SENT_ERROR,
        ],

        'SIS0298' => [
            'reason'  => 'El comercio no está configurado para realizar “Tarjeta en Archivo (P.Suscripciones/P.Exprés)”',
            'message' => self::MSG_DATA_SENT_ERROR,
        ],
    ];

    /**
     * @return array
     */
    public static function getErrors()
    {
        return (array) self::$errors;
    }

    /**
     * @param  string  $code The error code
     * @return boolean
     */
    public static function hasError($code)
    {
        $errors = self::getErrors();

        return array_key_exists($code, $errors);
    }

    /**
     * @param  string $code
     * @return array The error info or null if not found
     */
    public static function getError($code)
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
    public static function getMessages()
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
