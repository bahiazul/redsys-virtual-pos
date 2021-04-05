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
class Excep_Sca extends AbstractField implements FieldInterface
{
    use ValidableTrait;

    /**
     * Indicates if this field can appear in a request
     *
     * @var boolean
     */
    protected $inRequest = true;

    const EXEMPTION_MIT = 'MIT';
    const EXEMPTION_LWV = 'LWV';
    const EXEMPTION_TRA = 'TRA';
    const EXEMPTION_COR = 'COR';

    /**
     * Set of predefined values
     *
     * @var array
     */
    protected static $availableValues = [
        self::EXEMPTION_MIT => 'Transacción iniciada por el comercio',
        self::EXEMPTION_LWV => 'Bajo importe',
        self::EXEMPTION_TRA => 'Bajo riesgo',
        self::EXEMPTION_COR => 'Pago corporativo seguro',
    ];

    /**
     * @param mixed $value
     */
    public function __construct($value = null)
    {
        parent::__construct($value);

        $keys = serialize(array_keys(self::getAvailableValues()));

        $this->validationRules = [
            "in_array({$keys})",
        ];
    }
}
