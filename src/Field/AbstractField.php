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

use \nkm\RedsysVirtualPos\Util\Helper;

/**
 * Holds the value of a request/response parameter
 *
 * @package    Redsys Virtual POS
 * @author     Javier Zapata <javierzapata82@gmail.com>
 * @copyright  2014 Javier Zapata <javierzapata82@gmail.com>
 * @license    http://www.opensource.org/licenses/BSD-3-Clause  The BSD 3-Clause License
 * @link       http://github.com/nkm/redsys-virtual-pos
 */
abstract class AbstractField implements FieldInterface
{
    /**
     * The internal name of the field
     * @var string
     */
    protected $name;

    /**
     * The name of the field as a request parameter
     * @var string
     */
    protected $requestName;

    /**
     * The name of the field as a response parameter
     * @var string
     */
    protected $responseName;

    /**
     * Set of predefined values
     * @var array
     */
    protected static $availableValues;

    /**
     * The value of the field
     * @var string
     */
    protected $value;

    /**
     * The value that will be returned in case
     * that no value is specified (optional)
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
        if (!is_string($this->name)) {
            return Helper::stringify($this->name);
        }

        return $this->name;
    }

    /**
     * @return string
     */
    public function getRequestName()
    {
        if (!is_string($this->requestName)) {
            return Helper::stringify($this->requestName);
        }

        return $this->requestName;
    }

    /**
     * @return string
     */
    public function getResponseName()
    {
        if (!is_string($this->responseName)) {
            return Helper::stringify($this->responseName);
        }

        return $this->responseName;
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
     * @return  string|null
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
     * @return string
     */
    public function getValue()
    {
        $value = is_null($this->value)
               ? $this->defaultValue
               : $this->value;

        return (string) $value;
    }
}
