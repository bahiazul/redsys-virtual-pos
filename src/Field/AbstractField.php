<?php
/**
 * Redsys Virtual POS
 *
 * Copyright (c) 2014, Javier Zapata <javierzapata82@gmail.com>.
 * All rights reserved.
 *
 * Redistribution and use in source and binary forms, with or without
 * modification, are permitted provided that the following conditions
 * are met:
 *
 *   * Redistributions of source code must retain the above copyright
 *     notice, this list of conditions and the following disclaimer.
 *
 *   * Redistributions in binary form must reproduce the above copyright
 *     notice, this list of conditions and the following disclaimer in
 *     the documentation and/or other materials provided with the
 *     distribution.
 *
 *   * Neither the name of Javier Zapata nor the names of his
 *     contributors may be used to endorse or promote products derived
 *     from this software without specific prior written permission.
 *
 * THIS SOFTWARE IS PROVIDED BY THE COPYRIGHT HOLDERS AND CONTRIBUTORS
 * "AS IS" AND ANY EXPRESS OR IMPLIED WARRANTIES, INCLUDING, BUT NOT
 * LIMITED TO, THE IMPLIED WARRANTIES OF MERCHANTABILITY AND FITNESS
 * FOR A PARTICULAR PURPOSE ARE DISCLAIMED. IN NO EVENT SHALL THE
 * COPYRIGHT OWNER OR CONTRIBUTORS BE LIABLE FOR ANY DIRECT, INDIRECT,
 * INCIDENTAL, SPECIAL, EXEMPLARY, OR CONSEQUENTIAL DAMAGES (INCLUDING,
 * BUT NOT LIMITED TO, PROCUREMENT OF SUBSTITUTE GOODS OR SERVICES;
 * LOSS OF USE, DATA, OR PROFITS; OR BUSINESS INTERRUPTION) HOWEVER
 * CAUSED AND ON ANY THEORY OF LIABILITY, WHETHER IN CONTRACT, STRICT
 * LIABILITY, OR TORT (INCLUDING NEGLIGENCE OR OTHERWISE) ARISING IN
 * ANY WAY OUT OF THE USE OF THIS SOFTWARE, EVEN IF ADVISED OF THE
 * POSSIBILITY OF SUCH DAMAGE.
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
    private static function hasAvailableValues()
    {
        return is_array(static::$availableValues) && !empty(static::$availableValues);
    }

    /**
     * @param   string      $key    The key of the value to get
     * @return  string|null
     */
    private static function getAvailableValue($key)
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
    private static function hasAvailableValue($key)
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
