<?php
/**
 * Redsys Virtual POS
 *
 * @package    Redsys Virtual POS
 * @author     Javier Zapata <javierzapata82@gmail.com>
 * @copyright  2021 Javier Zapata <javierzapata82@gmail.com>
 * @license    https://opensource.org/licenses/MIT The MIT License
 * @link       https://github.com/bahiazul/redsys-virtual-pos
 */

namespace Bahiazul\RedsysVirtualPos\Field;

/**
 * Holds the value of a request/response parameter
 *
 * @package    Redsys Virtual POS
 * @author     Javier Zapata <javierzapata82@gmail.com>
 * @copyright  2021 Javier Zapata <javierzapata82@gmail.com>
 * @license    https://opensource.org/licenses/MIT The MIT License
 * @link       https://github.com/bahiazul/redsys-virtual-pos
 */
class ErrorCode extends AbstractField implements FieldInterface
{
    const ERROR_UNKNOWN_CODE    = 'Código de error desconocido';
    const ERROR_UNKNOWN_MESSAGE = 'Mensaje mostrado al cliente desconocido';

    /**
     * Indicates if this field can appear in a response
     *
     * @var boolean
     */
    protected $inResponse = true;

    const MSG_SYSTEM_BUSY                      = 'MSG0000';
    const MSG_ORDER_NUMBER_REPEATED            = 'MSG0001';
    const MSG_CARD_PIN_NOT_REGISTERED          = 'MSG0002';
    const MSG_SYSTEM_NOT_READY                 = 'MSG0003';
    const MSG_AUTH_ERROR                       = 'MSG0004';
    const MSG_CARD_NO_PAYMENT_METHOD_AVAILABLE = 'MSG0005';
    const MSG_CARD_NOT_ON_SERVICE              = 'MSG0006';
    const MSG_DATA_MISSING                     = 'MSG0007';
    const MSG_DATA_SENT_ERROR                  = 'MSG0008';
    const MSG_UNKNOWN                          = 'UNKNOWN';

    /**
     * Holds every kind of error
     *
     * @var array
     */
    private static $messageDescriptions = [
        self::MSG_SYSTEM_BUSY                      => 'El sistema está ocupado, inténtelo más tarde',
        self::MSG_ORDER_NUMBER_REPEATED            => 'Número de pedido repetido',
        self::MSG_CARD_PIN_NOT_REGISTERED          => 'El BIN de la tarjeta no está dado de alta en FINANET',
        self::MSG_SYSTEM_NOT_READY                 => 'El sistema está arrancando, inténtelo en unos momentos',
        self::MSG_AUTH_ERROR                       => 'Error de Autenticación',
        self::MSG_CARD_NO_PAYMENT_METHOD_AVAILABLE => 'No existe método de pago válido para su tarjeta',
        self::MSG_CARD_NOT_ON_SERVICE              => 'Tarjeta ajena al servicio',
        self::MSG_DATA_MISSING                     => 'Faltan datos, por favor compruebe que su navegador acepta cookies',
        self::MSG_DATA_SENT_ERROR                  => 'Error en datos enviados. Contacte con su comercio',
        self::MSG_UNKNOWN                          => self::ERROR_UNKNOWN_MESSAGE,
    ];

    /**
     * @var array
     */
    private static $errors = [
        'UNKNOWN' => [
            'reason'  => self::ERROR_UNKNOWN_CODE,
            'message' => self::MSG_UNKNOWN,
        ],

        'SIS0007' => [
            'reason'  => "Error al desmontar XML de entrada",
            'message' => self::MSG_DATA_SENT_ERROR,
        ],

        'SIS0008' => [
            'reason'  => 'Error. Falta `Ds_Merchant_MerchantCode`',
            'message' => self::MSG_DATA_SENT_ERROR,
        ],

        'SIS0009' => [
            'reason'  => 'Error de formato en `Ds_Merchant_MerchantCode`',
            'message' => self::MSG_DATA_SENT_ERROR,
        ],

        'SIS0010' => [
            'reason'  => 'Error. Falta `Ds_Merchant_Terminal`',
            'message' => self::MSG_DATA_SENT_ERROR,
        ],

        'SIS0011' => [
            'reason'  => 'Error de formato en `Ds_Merchant_Terminal`',
            'message' => self::MSG_DATA_SENT_ERROR,
        ],

        'SIS0014' => [
            'reason'  => 'Error de formato en `Ds_Merchant_Order`',
            'message' => self::MSG_DATA_SENT_ERROR,
        ],

        'SIS0015' => [
            'reason'  => 'Error. Falta `Ds_Merchant_Currency`',
            'message' => self::MSG_DATA_SENT_ERROR,
        ],

        'SIS0016' => [
            'reason'  => 'Error de formato en `Ds_Merchant_Currency`',
            'message' => self::MSG_DATA_SENT_ERROR,
        ],

        'SIS0017' => [
            'reason'  => 'Error. No se admiten operaciones en pesetas',
            'message' => self::MSG_DATA_SENT_ERROR,
        ],

        'SIS0018' => [
            'reason'  => 'Error. Falta `Ds_Merchant_Amount`',
            'message' => self::MSG_DATA_SENT_ERROR,
        ],

        'SIS0019' => [
            'reason'  => 'Error de formato en `Ds_Merchant_Amount`',
            'message' => self::MSG_DATA_SENT_ERROR,
        ],

        'SIS0020' => [
            'reason'  => 'Error. Falta `Ds_Merchant_Signature`',
            'message' => self::MSG_DATA_SENT_ERROR,
        ],

        'SIS0021' => [
            'reason'  => 'Error. La `Ds_Merchant_MerchantSignature` viene vacía',
            'message' => self::MSG_DATA_SENT_ERROR,
        ],

        'SIS0022' => [
            'reason'  => 'Error de formato en `Ds_Merchant_TransactionType`',
            'message' => self::MSG_DATA_SENT_ERROR,
        ],

        'SIS0023' => [
            'reason'  => 'Error. `Ds_Merchant_TransactionType` desconocido',
            'message' => self::MSG_DATA_SENT_ERROR,
        ],

        'SIS0024' => [
            'reason'  => 'Error. `Ds_Merchant_ConsumerLanguage` tiene mas de 3 posiciones',
            'message' => self::MSG_DATA_SENT_ERROR,
        ],

        'SIS0025' => [
            'reason'  => 'Error de formato en `Ds_ConsumerLanguage`',
            'message' => self::MSG_DATA_SENT_ERROR,
        ],

        'SIS0026' => [
            'reason'  => 'Error. No existe el comercio / Terminal enviado',
            'message' => self::MSG_DATA_SENT_ERROR,
        ],

        'SIS0027' => [
            'reason'  => 'Error. Moneda enviada por el comercio es diferente a la que tiene asignada para ese terminal',
            'message' => self::MSG_DATA_SENT_ERROR,
        ],

        'SIS0028' => [
            'reason'  => 'Error. Comercio / terminal está dado de baja',
            'message' => self::MSG_DATA_SENT_ERROR,
        ],

        'SIS0030' => [
            'reason'  => 'Error en un pago con tarjeta ha llegado un tipo de operación que no es ni pago ni preautorización',
            'message' => self::MSG_SYSTEM_BUSY,
        ],

        'SIS0031' => [
            'reason'  => 'Método de pago no definido',
            'message' => self::MSG_SYSTEM_BUSY,
        ],

        'SIS0033' => [
            'reason'  => 'Error en un pago con móvil ha llegado un tipo de operación que no es ni pago ni preautorización',
            'message' => self::MSG_SYSTEM_BUSY,
        ],

        'SIS0034' => [
            'reason'  => 'Error en acceso a la Base de Datos',
            'message' => self::MSG_SYSTEM_BUSY,
        ],

        'SIS0037' => [
            'reason'  => 'El número de teléfono no es válido',
            'message' => self::MSG_SYSTEM_BUSY,
        ],

        'SIS0038' => [
            'reason'  => 'Error en Java',
            'message' => self::MSG_SYSTEM_BUSY,
        ],

        'SIS0040' => [
            'reason'  => 'Error. El comercio / Terminal no tiene ningún método de pago asignado',
            'message' => self::MSG_DATA_SENT_ERROR,
        ],

        'SIS0041' => [
            'reason'  => 'Error. En el cálculo de la HASH de datos del comercio',
            'message' => self::MSG_DATA_SENT_ERROR,
        ],

        'SIS0042' => [
            'reason'  => 'La firma enviada no es correcta',
            'message' => self::MSG_DATA_SENT_ERROR,
        ],

        'SIS0043' => [
            'reason'  => 'Error al realizar la notificación on-line',
            'message' => self::MSG_DATA_SENT_ERROR,
        ],

        'SIS0046' => [
            'reason'  => 'El BIN (6 primeros dígitos de la tarjeta) no está dado de alta',
            'message' => self::MSG_CARD_PIN_NOT_REGISTERED,
        ],

        'SIS0051' => [
            'reason'  => 'Error. Número de pedido repetido',
            'message' => self::MSG_ORDER_NUMBER_REPEATED,
        ],

        'SIS0054' => [
            'reason'  => 'Error. No existe operación sobre la que realizar la devolución',
            'message' => self::MSG_DATA_SENT_ERROR,
        ],

        'SIS0055' => [
            'reason'  => 'Error. Existe más de un pago con el mismo número de pedido',
            'message' => self::MSG_DATA_SENT_ERROR,
        ],

        'SIS0056' => [
            'reason'  => 'La operación sobre la que se desea devolver no está autorizada',
            'message' => self::MSG_DATA_SENT_ERROR,
        ],

        'SIS0057' => [
            'reason'  => 'El importe a devolver supera el permitido',
            'message' => self::MSG_DATA_SENT_ERROR,
        ],

        'SIS0058' => [
            'reason'  => 'Inconsistencia de datos, en la validación de una confirmación',
            'message' => self::MSG_DATA_SENT_ERROR,
        ],

        'SIS0059' => [
            'reason'  => 'Error, no existe la operación sobre la que realizar la confirmación',
            'message' => self::MSG_DATA_SENT_ERROR,
        ],

        'SIS0060' => [
            'reason'  => 'Ya existe confirmación asociada a la preautorización',
            'message' => self::MSG_DATA_SENT_ERROR,
        ],

        'SIS0061' => [
            'reason'  => 'La preautorización sobre la que se desea confirmar no está autorizada',
            'message' => self::MSG_DATA_SENT_ERROR,
        ],

        'SIS0062' => [
            'reason'  => 'El importe a confirmar supera el permitido',
            'message' => self::MSG_DATA_SENT_ERROR,
        ],

        'SIS0063' => [
            'reason'  => 'Error. Número de tarjeta no disponible',
            'message' => self::MSG_DATA_SENT_ERROR,
        ],

        'SIS0064' => [
            'reason'  => 'Error. El número de tarjeta no puede tener más de 19 posiciones',
            'message' => self::MSG_DATA_SENT_ERROR,
        ],

        'SIS0065' => [
            'reason'  => 'Error. El número de tarjeta no es numérico',
            'message' => self::MSG_DATA_SENT_ERROR,
        ],

        'SIS0066' => [
            'reason'  => 'Error. Mes de caducidad no disponible',
            'message' => self::MSG_DATA_SENT_ERROR,
        ],

        'SIS0067' => [
            'reason'  => 'Error. El mes de la caducidad no es numérico',
            'message' => self::MSG_DATA_SENT_ERROR,
        ],

        'SIS0068' => [
            'reason'  => 'Error. El mes de la caducidad no es válido',
            'message' => self::MSG_DATA_SENT_ERROR,
        ],

        'SIS0069' => [
            'reason'  => 'Error. Año de caducidad no disponible',
            'message' => self::MSG_DATA_SENT_ERROR,
        ],

        'SIS0070' => [
            'reason'  => 'Error. El Año de la caducidad no es numérico',
            'message' => self::MSG_DATA_SENT_ERROR,
        ],

        'SIS0071' => [
            'reason'  => 'Tarjeta caducada',
            'message' => self::MSG_SYSTEM_BUSY,
        ],

        'SIS0072' => [
            'reason'  => 'Operación no anulable',
            'message' => self::MSG_SYSTEM_BUSY,
        ],

        'SIS0074' => [
            'reason'  => 'Error. Falta `Ds_Merchant_Order`',
            'message' => self::MSG_DATA_SENT_ERROR,
        ],

        'SIS0075' => [
            'reason'  => 'Error. El `Ds_Merchant_Order` tiene menos de 4 posiciones o más de 12',
            'message' => self::MSG_DATA_SENT_ERROR,
        ],

        'SIS0076' => [
            'reason'  => 'Error. El `Ds_Merchant_Order` no tiene las cuatro primeras posiciones numéricas',
            'message' => self::MSG_DATA_SENT_ERROR,
        ],

        'SIS0077' => [
            'reason'  => 'Error. El `Ds_Merchant_Order` no tiene las cuatro primeras posiciones numéricas. No se utiliza',
            'message' => self::MSG_SYSTEM_BUSY,
        ],

        'SIS0078' => [
            'reason'  => 'Método de pago no disponible',
            'message' => self::MSG_CARD_NO_PAYMENT_METHOD_AVAILABLE,
        ],

        'SIS0079' => [
            'reason'  => 'Error al realizar el pago con tarjeta',
            'message' => self::MSG_DATA_MISSING,
        ],

        'SIS0081' => [
            'reason'  => 'La sesión es nueva, se han perdido los datos almacenados',
            'message' => self::MSG_DATA_MISSING,
        ],

        'SIS0084' => [
            'reason'  => 'El valor de `Ds_Merchant_Conciliation` es nulo',
            'message' => self::MSG_DATA_SENT_ERROR,
        ],

        'SIS0085' => [
            'reason'  => 'El valor de `Ds_Merchant_Conciliation` no es numérico',
            'message' => self::MSG_DATA_SENT_ERROR,
        ],

        'SIS0086' => [
            'reason'  => 'El valor de `Ds_Merchant_Conciliation` no ocupa 6 posiciones',
            'message' => self::MSG_DATA_SENT_ERROR,
        ],

        'SIS0089' => [
            'reason'  => 'El valor de `Ds_Merchant_ExpiryDate` no ocupa 4 posiciones',
            'message' => self::MSG_DATA_SENT_ERROR,
        ],

        'SIS0092' => [
            'reason'  => 'El valor de `Ds_Merchant_ExpiryDate` es nulo',
            'message' => self::MSG_DATA_SENT_ERROR,
        ],

        'SIS0093' => [
            'reason'  => 'Tarjeta no encontrada en tabla de rangos',
            'message' => self::MSG_CARD_NOT_ON_SERVICE,
        ],

        'SIS0094' => [
            'reason'  => 'La tarjeta no fue autenticada como 3D Secure',
            'message' => self::MSG_AUTH_ERROR,
        ],

        'SIS0097' => [
            'reason'  => 'Valor del campo `Ds_Merchant_CComercio` no válido',
            'message' => self::MSG_AUTH_ERROR,
        ],

        'SIS0098' => [
            'reason'  => 'Valor del campo `Ds_Merchant_CVentana` no válido',
            'message' => self::MSG_AUTH_ERROR,
        ],

        'SIS0112' => [
            'reason'  => 'Error. El tipo de transacción especificado en `Ds_Merchant_Transaction_Type` no está permitido',
            'message' => self::MSG_DATA_SENT_ERROR,
        ],

        'SIS0113' => [
            'reason'  => 'Excepción producida en el servlet de operaciones',
            'message' => self::MSG_DATA_SENT_ERROR,
        ],

        'SIS0114' => [
            'reason'  => 'Error. Se ha llamado con un GET en lugar de un POST',
            'message' => self::MSG_SYSTEM_BUSY,
        ],

        'SIS0115' => [
            'reason'  => 'Error. No existe operación sobre la que realizar el pago de la cuota',
            'message' => self::MSG_DATA_SENT_ERROR,
        ],

        'SIS0116' => [
            'reason'  => 'La operación sobre la que se desea pagar una cuota no es válida',
            'message' => self::MSG_DATA_SENT_ERROR,
        ],

        'SIS0117' => [
            'reason'  => 'La operación sobre la que se desea pagar una cuota no está autorizada',
            'message' => self::MSG_DATA_SENT_ERROR,
        ],

        'SIS0118' => [
            'reason'  => 'Se ha excedido el importe total de las cuotas',
            'message' => self::MSG_DATA_SENT_ERROR,
        ],

        'SIS0119' => [
            'reason'  => 'Valor del campo `Ds_Merchant_DateFrecuency no válido',
            'message' => self::MSG_DATA_SENT_ERROR,
        ],

        'SIS0120' => [
            'reason'  => 'Valor del campo `Ds_Merchant_ChargeExpiryDate` no válido',
            'message' => self::MSG_DATA_SENT_ERROR,
        ],

        'SIS0121' => [
            'reason'  => 'Valor del campo `Ds_Merchant_SumTotal` no válido',
            'message' => self::MSG_DATA_SENT_ERROR,
        ],

        'SIS0122' => [
            'reason'  => 'Valor del campo `Ds_Merchant_DateFrecuency` o no `Ds_Merchant_SumTotal` tiene formato incorrecto',
            'message' => self::MSG_DATA_SENT_ERROR,
        ],

        'SIS0123' => [
            'reason'  => 'Se ha excedido la fecha tope para realizar transacciones',
            'message' => self::MSG_DATA_SENT_ERROR,
        ],

        'SIS0124' => [
            'reason'  => 'No ha transcurrido la frecuencia mínima en un pago recurrente sucesivo',
            'message' => self::MSG_DATA_SENT_ERROR,
        ],

        'SIS0132' => [
            'reason'  => 'La fecha de Confirmación de Autorización no puede superar en más de 7 días a la de Preautorización',
            'message' => self::MSG_DATA_SENT_ERROR,
        ],

        'SIS0133' => [
            'reason'  => 'La fecha de Confirmación de Autenticación no puede superar en más de 45 días a la de Autenticación Previa',
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

        'SIS0197' => [
            'reason'  => 'Error al obtener los datos de cesta de la compra en operación tipo pasarela',
            'message' => self::MSG_SYSTEM_BUSY,
        ],

        'SIS0198' => [
            'reason'  => 'Error. El importe supera el límite permitido para el comercio',
            'message' => self::MSG_SYSTEM_BUSY,
        ],

        'SIS0199' => [
            'reason'  => 'Error. El número de operaciones supera el límite permitido para el comercio',
            'message' => self::MSG_DATA_SENT_ERROR,
        ],

        'SIS0200' => [
            'reason'  => 'Error. El importe acumulado supera el límite permitido para el comercio',
            'message' => self::MSG_DATA_SENT_ERROR,
        ],

        'SIS0214' => [
            'reason'  => 'El comercio no admite devoluciones',
            'message' => self::MSG_DATA_SENT_ERROR,
        ],

        'SIS0216' => [
            'reason'  => 'Error. `Ds_Merchant_CVV2` tiene más de 3 posiciones',
            'message' => self::MSG_DATA_SENT_ERROR,
        ],

        'SIS0217' => [
            'reason'  => 'Error de formato en `Ds_Merchant_CVV2`',
            'message' => self::MSG_DATA_SENT_ERROR,
        ],

        'SIS0218' => [
            'reason'  => 'El comercio no permite operaciones seguras por la entrada /operaciones',
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
            'reason'  => 'Valor del campo `Ds_Merchant_TransactionDate` no válido',
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
            'reason'  => 'Esta tarjeta no permite operativa de preautorizaciones',
            'message' => self::MSG_DATA_SENT_ERROR,
        ],

        'SIS0258' => [
            'reason'  => 'Inconsistencia de datos en la validación de una confirmación',
            'message' => self::MSG_DATA_SENT_ERROR,
        ],

        'SIS0261' => [
            'reason'  => 'Operación detenida por superar el control de restricciones en la entrada al SIS',
            'message' => self::MSG_DATA_SENT_ERROR,
        ],

        'SIS0270' => [
            'reason'  => 'El comercio no puede realizar autorizaciones en diferido',
            'message' => self::MSG_DATA_SENT_ERROR,
        ],

        'SIS0274' => [
            'reason'  => 'Tipo de operación desconocida o no permitida por esta entrada al SIS',
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
            'reason'  => 'Superado el número máximo de operaciones (99 oper. o 1 año) para realizar transacciones sucesivas de “Tarjeta en Archivo (P.Suscripciones/P.Exprés)”. Se requiere realizar una nueva operación de “Tarjeta en Archivo Inicial” para iniciar el ciclo.',
            'message' => self::MSG_DATA_SENT_ERROR,
        ],

        'SIS0298' => [
            'reason'  => 'El comercio no está configurado para realizar “Tarjeta en Archivo (P.Suscripciones/P.Exprés)”',
            'message' => self::MSG_DATA_SENT_ERROR,
        ],

        'SIS0429' => [
            'reason'  => 'Error en la versión enviada por el comercio en el parámetro `Ds_SignatureVersion`',
            'message' => self::MSG_DATA_SENT_ERROR,
        ],

        'SIS0430' => [
            'reason'  => 'Error al decodificar el parámetro `Ds_MerchantParameters`',
            'message' => self::MSG_DATA_SENT_ERROR,
        ],

        'SIS0431' => [
            'reason'  => 'Error del objeto JSON que se envía codificado en el parámetro `Ds_MerchantParameters`',
            'message' => self::MSG_DATA_SENT_ERROR,
        ],

        'SIS0432' => [
            'reason'  => 'Error. FUC del comercio erróneo',
            'message' => self::MSG_DATA_SENT_ERROR,
        ],

        'SIS0433' => [
            'reason'  => 'Error. Terminal del comercio erróneo',
            'message' => self::MSG_DATA_SENT_ERROR,
        ],

        'SIS0434' => [
            'reason'  => 'Error. Ausencia de número de pedido en la operación enviada por el comercio',
            'message' => self::MSG_DATA_SENT_ERROR,
        ],

        'SIS0435' => [
            'reason'  => 'Error en el cáculo de la firma',
            'message' => self::MSG_DATA_SENT_ERROR,
        ],

        'SIS0436' => [
            'reason'  => 'Error en la construcción del elemento padre <REQUEST>',
            'message' => self::MSG_DATA_SENT_ERROR,
        ],

        'SIS0437' => [
            'reason'  => 'Error en la construcción del elemento <DS_SIGNATUREVERSION>',
            'message' => self::MSG_DATA_SENT_ERROR,
        ],

        'SIS0438' => [
            'reason'  => 'Error en la construcción del elemento <DATOSENTRADA>',
            'message' => self::MSG_DATA_SENT_ERROR,
        ],

        'SIS0439' => [
            'reason'  => 'Error en la construcción del elemento <DS_SIGNATURE>',
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
        $errors = self::getErrors();
        if (!self::hasError($code)) {
            return $errors['UNKNOWN'];
        }

        return $errors[$code];
    }

    /**
     * @return array
     */
    public static function getMessageDescriptions()
    {
        return (array) self::$messageDescriptions;
    }

    /**
     * @param  string  $message The message code
     * @return boolean
     */
    public static function hasMessageDescription($message)
    {
        $messageDescriptions = self::getMessageDescriptions();

        return array_key_exists($message, $messageDescriptions);
    }

    /**
     * @param  string $message
     * @return string The description of the message type
     */
    public static function getMessageDescription($message)
    {
        $messageDescriptions = self::getMessageDescriptions();
        if (!self::hasMessageDescription($message)) {
            return $messageDescriptions[self::MSG_UNKNOWN];
        }

        return $messageDescriptions[$message];
    }

    /**
     * @return string The reason for the error
     */
    public function getReason()
    {
        $error = self::getError($this->value);

        if (!isset($error['reason'])) {
            return null;
        }

        return $error['reason'];
    }

    /**
     * @return string The message shown to the end-user
     */
    public function getMessage()
    {
        $error = self::getError($this->value);

        if (!isset($error['message'])) {
            return null;
        }

        return $error['message'];
    }
}
