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
class Acquirer_Identifier extends AbstractField implements FieldInterface
{
    use ValidableTrait;

    /**
     * Indicates if this field can appear in a request
     *
     * @var boolean
     */
    protected $inRequest = true;

    /**
     * The prefix of the field when going on a request
     *
     * @var string
     */
    protected $requestPrefix = 'Ds_';

    /**
     * @param mixed $value
     */
    public function __construct($value = null)
    {
        parent::__construct($value);

        $this->validationRules = [
            'numeric',
            'max_length(6)',
        ];
    }
}
