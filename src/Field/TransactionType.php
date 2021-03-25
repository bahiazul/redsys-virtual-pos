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

namespace nkm\RedsysVirtualPos\Field;

/**
 * Holds the value of a request/response parameter
 *
 * @package    Redsys Virtual POS
 * @author     Javier Zapata <javierzapata82@gmail.com>
 * @copyright  2021 Javier Zapata <javierzapata82@gmail.com>
 * @license    https://opensource.org/licenses/MIT The MIT License
 * @link       https://github.com/jzfgo/redsys-virtual-pos
 */
class TransactionType extends AbstractField implements FieldInterface
{
    use ValidableTrait;

    /**
     * Indicates if this field can appear in a request
     *
     * @var boolean
     */
    protected $inRequest = true;

    /**
     * Indicates if this field can appear in a response
     *
     * @var boolean
     */
    protected $inResponse = true;

    const STANDARD                    = '0';
    const PREAUTH                     = '1';
    const PREAUTH_CONFIRM             = '2';
    const REFUND                      = '3';
    const RECURRING                   = '5';
    const SUCCESSIVE                  = '6';
    const AUTH                        = '7';
    const AUTH_CONFIRM                = '8';
    const PREAUTH_CANCEL              = '9';
    const INSECURE_NOAUTH             = 'A';
    const FILEDCARD_INITIAL           = 'L';
    const FILEDCARD_SUCCESSIVE        = 'M';
    const DEFER_PREAUTH               = 'O';
    const DEFER_PREAUTH_CONFIRM       = 'P';
    const DEFER_PREAUTH_CANCEL        = 'Q';
    const RECUR_DEFER_AUTH_INITIAL    = 'R';
    const RECUR_DEFER_AUTH_SUCCESSIVE = 'S';

    /**
     * Set of predefined values
     *
     * @var array
     */
    protected static $availableValues = [
        self::STANDARD                    => 'Pago estándar',
        self::PREAUTH                     => 'Preautorización',
        self::PREAUTH_CONFIRM             => 'Confirmación de Preautorización',
        self::REFUND                      => 'Devolución parcial o total',
        self::RECURRING                   => 'Transacción Recurrente',
        self::SUCCESSIVE                  => 'Transacción Sucesiva',
        self::AUTH                        => 'Autenticación',
        self::AUTH_CONFIRM                => 'Confirmación de Autenticación',
        self::PREAUTH_CANCEL              => 'Anulación de Preautorización',
        self::INSECURE_NOAUTH             => 'Pago no seguro sin autenticación',
        self::FILEDCARD_INITIAL           => 'Tarjeta en Archivo Inicial (P. Suscripciones/P. Exprés)',
        self::FILEDCARD_SUCCESSIVE        => 'Tarjeta en Archivo Sucesiva (P. Suscripciones/P. Exprés)',
        self::DEFER_PREAUTH               => 'Preautorización Diferida',
        self::DEFER_PREAUTH_CONFIRM       => 'Confirmación de Preautorización Diferida',
        self::DEFER_PREAUTH_CANCEL        => 'Anulación de Preautorización Diferida',
        self::RECUR_DEFER_AUTH_INITIAL    => 'Autorización recurrente inicial diferido',
        self::RECUR_DEFER_AUTH_SUCCESSIVE => 'Autorización recurrente sucesiva diferido',
    ];

    /**
     * @param mixed $value
     */
    public function __construct($value = null)
    {
        parent::__construct($value);

        $this->defaultValue = self::STANDARD;

        $keys = serialize(array_keys(self::getAvailableValues()));

        $this->validationRules = [
            "in_array({$keys})",
        ];
    }
}
