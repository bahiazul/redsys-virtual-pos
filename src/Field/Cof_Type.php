<?php
/**
 * Redsys Virtual POS
 *
 * @package    Redsys Virtual POS
 * @author     Javier Zapata <javierzapata82@gmail.com>
 * @copyright  2020 Javier Zapata <javierzapata82@gmail.com>
 * @license    https://www.opensource.org/licenses/BSD-3-Clause  The BSD 3-Clause License
 * @link       https://github.com/jzfgo/redsys-virtual-pos
 */

namespace nkm\RedsysVirtualPos\Field;

/**
 * Holds the value of a request/response parameter
 *
 * @package    Redsys Virtual POS
 * @author     Javier Zapata <javierzapata82@gmail.com>
 * @copyright  2020 Javier Zapata <javierzapata82@gmail.com>
 * @license    https://www.opensource.org/licenses/BSD-3-Clause  The BSD 3-Clause License
 * @link       https://github.com/jzfgo/redsys-virtual-pos
 */
class Cof_Type extends AbstractField implements FieldInterface
{
    use ValidableTrait;

    /**
     * Indicates if this field can appear in a request
     *
     * @var boolean
     */
    protected $inRequest = true;

    const TYPE_INSTALLMENT     = 'I';
    const TYPE_RECURRING       = 'R';
    const TYPE_REAUTHORIZATION = 'H';
    const TYPE_RESUBMISSION    = 'E';
    const TYPE_DELAYED         = 'D';
    const TYPE_INCREMENTAL     = 'M';
    const TYPE_NOSHOW          = 'N';
    const TYPE_OTHER           = 'C';

    /**
     * Set of predefined values
     *
     * @var array
     */
    protected static $availableValues = [
        self::TYPE_INSTALLMENT     => 'Cuota',
        self::TYPE_RECURRING       => 'Recurrente',
        self::TYPE_REAUTHORIZATION => 'Reautorización',
        self::TYPE_RESUBMISSION    => 'Reenvío',
        self::TYPE_DELAYED         => 'Retrasado',
        self::TYPE_INCREMENTAL     => 'Incremental',
        self::TYPE_NOSHOW          => 'No Show',
        self::TYPE_OTHER           => 'Otras',
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
