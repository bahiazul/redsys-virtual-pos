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
class WebTransactionType extends AbstractTransactionType implements FieldInterface
{
    const STANDARD = '0';
    const AUTH     = '7';

    protected static $availableValues = [
        self::STANDARD => 'Pago estándar',
        self::AUTH     => 'Autenticación',
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

    /**
     * @return array
     */
    protected static function getAvailableValues()
    {
        $availableValues = array_merge(parent::$availableValues, self::$availableValues);
        ksort($availableValues);

        return $availableValues;
    }
}
