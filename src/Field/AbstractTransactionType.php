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
abstract class AbstractTransactionType extends AbstractField implements FieldInterface
{
    use ValidableTrait;

    protected $name         = 'TransactionType';
    protected $requestName  = 'Ds_Merchant_TransactionType';
    protected $responseName = 'Ds_TransactionType';

    const PREAUTH               = '1';
    const PREAUTH_CONFIRM       = '2';
    const REFUND                = '3';
    const AUTH_CONFIRM          = '8';
    const PREAUTH_CANCEL        = '9';
    const FILEDCARD_INITIAL     = 'L';
    const FILEDCARD_SUCCESSIVE  = 'M';
    const DEFER_PREAUTH         = 'O';
    const DEFER_PREAUTH_CONFIRM = 'P';
    const DEFER_PREAUTH_CANCEL  = 'Q';

    protected static $availableValues = [
        self::PREAUTH               => 'Preautorización',
        self::PREAUTH_CONFIRM       => 'Confirmación de Preautorización',
        self::REFUND                => 'Devolución parcial o total',
        self::AUTH_CONFIRM          => 'Confirmación de Autenticación',
        self::PREAUTH_CANCEL        => 'Anulación de Preautorización',
        self::FILEDCARD_INITIAL     => 'Tarjeta en Archivo Inicial (P. Suscripciones/P. Exprés)',
        self::FILEDCARD_SUCCESSIVE  => 'Tarjeta en Archivo Sucesiva (P. Suscripciones/P. Exprés)',
        self::DEFER_PREAUTH         => 'Preautorización Diferida',
        self::DEFER_PREAUTH_CONFIRM => 'Confirmación de Preautorización Diferida',
        self::DEFER_PREAUTH_CANCEL  => 'Anulación de Preautorización Diferida',
    ];
}
