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
class SecurePayment extends AbstractField implements FieldInterface
{
    use ValidableTrait;

    protected $name         = 'SecurePayment';
    protected $responseName = 'Ds_SecurePayment';

    const NOT_SECURE = '0';
    const SECURE     = '1';

    protected static $availableValues = [
        self::NOT_SECURE => 'Pago NO seguro',
        self::SECURE     => 'Pago seguro',
    ];

    /**
     * @return boolean|null
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
