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
class SignatureVersion extends AbstractField implements FieldInterface
{
    use ValidableTrait;

    /**
     * The prefix of the field when going on a request
     *
     * @var string
     */
    protected $requestPrefix = 'Ds_';

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

    const HMAC_SHA256_V1 = 'HMAC_SHA256_V1';

    /**
     * Set of predefined values
     *
     * @var array
     */
    protected static $availableValues = [
        self::HMAC_SHA256_V1 => 'HMAC_SHA256_V1',
    ];

    /**
     * @param mixed $value
     */
    public function __construct($value = null)
    {
        parent::__construct($value);

        $this->defaultValue = self::HMAC_SHA256_V1;

        $keys = serialize(array_keys(self::getAvailableValues()));

        $this->validationRules = [
            'required',
            "in_array({$keys})",
        ];
    }
}
