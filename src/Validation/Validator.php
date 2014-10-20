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

namespace nkm\RedsysVirtualPos\Validation;

/**
 * Simple Validator Class for php
 * @author Can Geliş <geliscan@gmail.com>
 * @copyright (c) 2013, Can Geliş
 * @license https://github.com/nkm/simple-validator/blob/master/licence.txt MIT Licence
 * @link https://github.com/nkm/simple-validator
 */

/**
 * TODO: Exception handling for rules with parameters
 * TODO: add protection filters for several input vulnerabilities.
 */
class Validator implements ValidatorInterface
{
    private $errors                    = array();
    private $namings                   = array();
    private $customErrorsWithInputName = array();
    private $customErrors              = array();

    /**
     * Constructor is not allowed because SimpleValidator uses its own
     * static method to instantiate the validation
     */
    final private function __construct($errors, $namings)
    {
        $this->errors  = (array) $errors;
        $this->namings = (array) $namings;
    }

    /**
     * @return boolean
     */
    final public function isSuccess()
    {
        return (empty($this->errors) == true);
    }

    /**
     * @param Array $errors_array
     */
    final public function customErrors($errors_array)
    {
        foreach ($errors_array as $key => $value) {
            // handle input.rule eg (name.required)
            if (preg_match("#^(.+?)\.(.+?)$#", $key, $matches) === 1) {
                // $this->customErrorsWithInputName[name][required] = error message
                $this->customErrorsWithInputName[(string) $matches[1]][(string) $matches[2]] = $value;
            } else {
                $this->customErrors[(string) $key] = $value;
            }
        }
    }

    /**
     * @return string
     */
    protected function getDefaultLang()
    {
        return 'es';
    }

    /**
     * @return null
     */
    protected function getErrorFilePath($lang)
    {
        return null;
    }

    /**
     * @return array
     */
    final protected function getDefaultErrorTexts($lang = null)
    {
        $lang = preg_replace('/[^a-z]+/', '', $lang);

        /* handle default error text file */
        $path = __DIR__ . "/errors/{$lang}.php";

        return $this->getErrorTexts($path);
    }

    /**
     * @return array
     */
    final protected function getCustomErrorTexts($lang = null)
    {
        /* handle error text file for custom validators */
        $path = $this->getErrorFilePath($lang);

        return $this->getErrorTexts($path);
    }

    /**
     * @return array
     */
    final private function getErrorTexts($path)
    {
        $error_texts = array();
        if (file_exists($path)) {
            $error_texts = include($path);
        }

        return $error_texts;
    }

    final protected function handleNaming($input_name)
    {
        if (isset($this->namings[(string) $input_name])) {
            $named_input = $this->namings[(string) $input_name];
        } else {
            $named_input = $input_name;
        }

        return $named_input;
    }

    final protected function handleParameterNaming($params)
    {
        foreach ($params as $key => $param) {
            if (preg_match("#^:([a-zA-Z0-9_]+)$#", $param, $param_type) === 1) {
                if (isset($this->namings[(string) $param_type[1]])) {
                    $params[$key] = $this->namings[(string) $param_type[1]];
                } else {

                    $params[$key] = $param_type[1];
                }
            }
        }

        return $params;
    }

    /**
     *
     * @param string $error_file
     * @return array
     * @throws ValidatorException
     */
    final public function getErrors($lang = null)
    {
        $lang || $lang = $this->getDefaultLang();

        $error_results = array();
        $default_error_texts = $this->getDefaultErrorTexts($lang);
        $custom_error_texts  = $this->getCustomErrorTexts($lang);
        foreach ($this->errors as $input_name => $results) {
            foreach ($results as $rule => $result) {
                $named_input = $this->handleNaming($input_name);

                /**
                 * if parameters are input name they should be named as well
                 */
                $result['params'] = $this->handleParameterNaming($result['params']);

                // if there is a custom message with input name, apply it
                if (isset($this->customErrorsWithInputName[(string) $input_name][(string) $rule])) {
                    $error_message = $this->customErrorsWithInputName[(string) $input_name][(string) $rule];
                }

                // if there is a custom message for the rule, apply it
                elseif (isset($this->customErrors[(string) $rule])) {
                    $error_message = $this->customErrors[(string) $rule];
                }

                // if there is a custom validator try to fetch it from its error file
                elseif (isset($custom_error_texts[(string) $rule])) {
                    $error_message = $custom_error_texts[(string) $rule];
                }

                // if none try to fetch from default error file
                elseif (isset($default_error_texts[(string) $rule])) {
                    $error_message = $default_error_texts[(string) $rule];
                }

                else {
                    throw new ValidatorException(ValidatorException::NO_ERROR_TEXT, $rule);
                }

                /**
                 * handle :params(..)
                 */
                if (preg_match_all("#:params\((.+?)\)#", $error_message, $param_indexes) >= 1) {
                    foreach ($param_indexes[1] as $param_index) {
                        $error_message = str_replace(
                            ":params(" . $param_index . ")",
                            $result['params'][$param_index],
                            $error_message
                        );
                    }
                }

                $error_results[] = str_replace(":attribute", $named_input, $error_message);
            }
        }

        return $error_results;
    }

    /**
     *
     * @return boolean
     */
    final public function has($input_name, $rule_name = null)
    {
        if ($rule_name != null) {
            return isset($this->errors[$input_name][$rule_name]);
        }

        return isset($this->errors[$input_name]);
    }

    /**
     * @return array
     */
    final public function getResults()
    {
        return $this->errors;
    }

    /**
     * Gets the parameter names of a rule
     * @param type $rule
     * @return mixed
     */
    final private static function getParams($rule)
    {
        if (preg_match("#^([a-zA-Z0-9_]+)\((.+?)\)$#", $rule, $matches) === 1) {
            return array(
                'rule'   => $matches[1],
                'params' => explode(",", $matches[2])
            );
        }

        return array(
            'rule'   => $rule,
            'params' => array()
        );
    }

    /**
     * Handle parameter with input name
     * eg: equals(:name)
     * @param mixed $params
     * @return mixed
     */
    final private static function getParamValues($params, $inputs)
    {
        foreach ($params as $key => $param) {
            if (preg_match("#^:([a-zA-Z0-9_]+)$#", $param, $param_type) === 1) {
                $params[$key] = @$inputs[(string) $param_type[1]];
            }
        }

        return $params;
    }

    /**
     *
     * @param Array $inputs
     * @param Array $rules
     * @param Array $naming
     * @return Validator
     * @throws ValidatorException
     */
    final public static function validate($inputs, $rules, $naming = null)
    {
        $errors = null;
        foreach ($rules as $input => $input_rules) {
            if (is_array($input_rules)) {
                foreach ($input_rules as $rule => $closure) {
                    if (!isset($inputs[(string) $input])) {
                        $input_value = null;
                    } else {
                        $input_value = $inputs[(string) $input];
                    }

                    /**
                     * if the key of the $input_rules is numeric that means
                     * it's neither an anonymous nor an user function.
                     */
                    if (is_numeric($rule)) {
                        $rule = $closure;
                    }

                    $rule_and_params = static::getParams($rule);
                    $rule = $rule_and_params['rule'];
                    $params = $real_params = $rule_and_params['params'];
                    $params = static::getParamValues($params, $inputs);
                    array_unshift($params, $input_value);

                    /*
                     * Detect the type of validator
                     */
                    if (@get_class($closure) == 'Closure') {
                        $refl_func  = new \ReflectionFunction($closure);
                        $validator_type = 'closure';
                    } elseif (@method_exists(get_called_class(), $rule)) {
                        $refl = new \ReflectionMethod(get_called_class(), $rule);

                        if (!$refl->isStatic()) {
                            throw new ValidatorException(ValidatorException::STATIC_METHOD, $rule);
                        }

                        $validator_type = 'method';
                    } else {
                        throw new ValidatorException(ValidatorException::UNKNOWN_RULE, $rule);
                    }

                    /*
                     * If empty but not required, no further validation necessary
                     */
                    if (static::blank($input_value) && $closure !== 'required') {
                        continue;
                    }

                    /**
                     * Handle validation
                     */
                    if ($validator_type === 'closure') {
                        $validation = $refl_func->invokeArgs($params);
                    } elseif ($validator_type === 'method') {
                        $refl->setAccessible(true);
                        $validation = $refl->invokeArgs(null, $params);
                    }

                    if ($validation == false) {
                        $errors[(string) $input][(string) $rule]['result'] = false;
                        $errors[(string) $input][(string) $rule]['params'] = $real_params;
                    }
                }
            } else {
                throw new ValidatorException(ValidatorException::ARRAY_EXPECTED, $input);
            }
        }

        return new static($errors, $naming);
    }

    protected static function alpha_numeric($input)
    {
        return (preg_match("#^[a-zA-Z0-9]+$#", $input) === 1);
    }

    protected static function alpha($input)
    {
        return (preg_match("#^[a-zA-Z]+$#", $input) === 1);
    }

    protected static function blank($input = null)
    {
        is_string($input) && $input = trim($input);

        return is_null($input) || $input === '';
    }

    protected static function email($input)
    {
        return filter_var($input, FILTER_VALIDATE_EMAIL);
    }

    protected static function equals($input, $param)
    {
        return ($input == $param);
    }

    protected static function exact_length($input, $length)
    {
        return (strlen($input) == $length);
    }

    /*
     * @link http://php.net/manual/function.is-float.php#109015
     * with a slight change in the 15th character to allow '-3.' to match
     */
    protected static function float($input)
    {
        $pattern = '/^[+-]?(\d*\.\d*([eE]?[+-]?\d+)?|\d+[eE][+-]?\d+)$/';

        is_string($input) && $input = trim($input);

        return (!is_bool($input) && (is_float($input) || preg_match($pattern, $input) === 1));
    }

    protected static function integer($input)
    {
        is_string($input) && $input = trim($input);

        return is_int($input) || ($input == (string) (int) $input);
    }

    protected static function ip($input)
    {
        return filter_var($input, FILTER_VALIDATE_IP);
    }

    protected static function max_length($input, $length)
    {
        return (strlen($input) <= $length);
    }

    protected static function min_length($input, $length)
    {
        return (strlen($input) >= $length);
    }

    protected static function numeric($input)
    {
        is_string($input) && $input = trim($input);

        return is_numeric($input);
    }

    protected static function required($input = null)
    {
        return !static::blank($input);
    }

    protected static function in_array($input, $serialized)
    {
        return in_array($input, unserialize($serialized));
    }

    protected static function match_regex($input, $regex)
    {
        return preg_match($regex, $input) === 1;
    }

    /*
     * TODO: need improvements for tel and urn urls.
     * check out url.test.php for the test result
     * urn syntax: http://www.faqs.org/rfcs/rfc2141.html
     *
     */

    protected static function url($input)
    {
        return filter_var($input, FILTER_VALIDATE_URL);
    }
}
