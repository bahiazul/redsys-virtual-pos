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
class Order extends AbstractField implements FieldInterface
{
    use ValidableTrait;

    protected $name         = 'Order';
    protected $requestName  = 'Ds_Merchant_Order';
    protected $responseName = 'Ds_Order';

    /**
     * @param mixed $value
     */
    public function __construct($value = null)
    {
        parent::__construct($value);

        $this->validationRules = [
            'required',
            'max_length(12)',
            'match_regex(/^[\d]{4}[A-Za-z0-9]+$/)',
        ];
    }
}
