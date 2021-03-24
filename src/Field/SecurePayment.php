<?php
/**
 * Redsys Virtual POS
 *
 * @package    Redsys Virtual POS
 * @author     Javier Zapata <javierzapata82@gmail.com>
 * @copyright  2021 Javier Zapata <javierzapata82@gmail.com>
 * @license    https://www.opensource.org/licenses/BSD-3-Clause  The BSD 3-Clause License
 * @link       https://github.com/jzfgo/redsys-virtual-pos
 */

namespace nkm\RedsysVirtualPos\Field;

/**
 * Holds the value of a request/response parameter
 *
 * @package    Redsys Virtual POS
 * @author     Javier Zapata <javierzapata82@gmail.com>
 * @copyright  2021 Javier Zapata <javierzapata82@gmail.com>
 * @license    https://www.opensource.org/licenses/BSD-3-Clause  The BSD 3-Clause License
 * @link       https://github.com/jzfgo/redsys-virtual-pos
 */
class SecurePayment extends AbstractField implements FieldInterface
{
    use ValidableTrait;

    /**
     * Indicates if this field can appear in a response
     *
     * @var boolean
     */
    protected $inResponse = true;

    const NOT_SECURE = '0';
    const SECURE     = '1';

    /**
     * Set of predefined values
     *
     * @var array
     */
    protected static $availableValues = [
        self::NOT_SECURE => 'Pago NO seguro',
        self::SECURE     => 'Pago seguro',
    ];

    /**
     * @return boolean
     */
    public function getIsSecure()
    {
        $val = $this->getValue();

        if ($val === self::NOT_SECURE) {
            return false;
        }

        if ($val === self::SECURE) {
            return true;
        }

        return null;
    }
}
