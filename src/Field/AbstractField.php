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

use Bahiazul\RedsysVirtualPos\Util\Helper;

/**
 * Holds the value of a request/response parameter
 *
 * @package    Redsys Virtual POS
 * @author     Javier Zapata <javierzapata82@gmail.com>
 * @copyright  2021 Javier Zapata <javierzapata82@gmail.com>
 * @license    https://opensource.org/licenses/MIT The MIT License
 * @link       https://github.com/bahiazul/redsys-virtual-pos
 */
abstract class AbstractField implements FieldInterface
{
    /**
     * The prefix of the field when going on a request
     *
     * @var string
     */
    protected $requestPrefix = 'Ds_Merchant_';

    /**
     * The prefix of the field when going on a response
     *
     * @var string
     */
    protected $responsePrefix = 'Ds_';

    /**
     * Indicates if this field can appear in a request
     *
     * @var boolean
     */
    protected $inRequest;

    /**
     * Indicates if this field can appear in a response
     *
     * @var boolean
     */
    protected $inResponse;

    /**
     * Set of predefined values
     *
     * @var array
     */
    protected static $availableValues;

    /**
     * The value of the field
     *
     * @var string
     */
    protected $value;

    /**
     * The value that will be returned in case
     * that no value is specified (optional)
     *
     * @var string
     */
    protected $defaultValue;

    /**
     * @param mixed $value
     */
    public function __construct($value = null)
    {
        if (!is_null($value)) {
            $this->setValue($value);
        }
    }

    /**
     * @return string
     */
    public function getName()
    {
        return (new \ReflectionClass($this))->getShortName();
    }

    /**
     * @return string
     */
    public function getRequestName()
    {
        $fieldName = $this->getName();

        if ($this->inRequest !== true) {
            throw new FieldException("Field `{$fieldName}` has no Request Name.");
        }

        return $this->requestPrefix.$fieldName;
    }

    /**
     * @return string
     */
    public function getResponseName()
    {
        $fieldName = $this->getName();

        if ($this->inResponse !== true) {
            throw new FieldException("Field `{$fieldName}` has no Response Name.");
        }

        return $this->responsePrefix.$fieldName;
    }

    /**
     * @return array
     */
    protected static function getAvailableValues()
    {
        if (!is_array(static::$availableValues)) {
            return [];
        }

        return static::$availableValues;
    }

    /**
     * @return boolean
     */
    public static function hasAvailableValues()
    {
        return is_array(static::$availableValues) && !empty(static::$availableValues);
    }

    /**
     * @param   string      $key    The key of the value to get
     * @return  string
     */
    public static function getAvailableValue($key)
    {
        if (!self::hasAvailableValue($key)) {
            return null;
        }

        return static::$availableValues[$key];
    }

    /**
     * @param  string $key The key of the value to check
     * @return boolean
     */
    public static function hasAvailableValue($key)
    {
        if (!self::hasAvailableValues()) {
            return false;
        }

        return array_key_exists($key, static::$availableValues);
    }

    /**
     * @param mixed $value The value of the field
     * @return FieldInterface
     */
    public function setValue($value)
    {
        $this->value = Helper::stringify($value);

        return $this;
    }

    /**
     * @return string   The value of the field or null if not defined
     */
    public function getValue()
    {
        $value = is_null($this->value)
               ? $this->defaultValue
               : $this->value;

        return $value;
    }
}
