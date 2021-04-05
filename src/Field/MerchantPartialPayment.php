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
class MerchantPartialPayment extends AbstractField implements FieldInterface
{
    use ValidableTrait;

    /**
     * Indicates if this field can appear in a response
     *
     * @var boolean
     */
    protected $inResponse = true;

    const NOT_PARTIAL = '0';
    const PARTIAL     = '1';

    /**
     * Set of predefined values
     *
     * @var array
     */
    protected static $availableValues = [
        self::NOT_PARTIAL => 'Pago NO parcial',
        self::PARTIAL     => 'Pago parcial',
    ];

    /**
     * @return boolean
     */
    public function getIsPartial()
    {
        $val = $this->getValue();

        if ($val === self::NOT_PARTIAL) {
            return false;
        }

        if ($val === self::PARTIAL) {
            return true;
        }

        return null;
    }
}
