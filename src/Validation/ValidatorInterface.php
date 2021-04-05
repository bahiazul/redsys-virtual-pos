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

namespace Bahiazul\RedsysVirtualPos\Validation;

/**
 * Simple Validator Class for php
 * @author Can Geliş <geliscan@gmail.com>
 * @copyright (c) 2013, Can Geliş
 * @license https://github.com/jzfgo/simple-validator/blob/master/licence.txt MIT Licence
 * @link https://github.com/jzfgo/simple-validator
 */

interface ValidatorInterface
{
    /**
     * @return boolean
     */
    public function isSuccess();

    /**
     * @param Array $errors_array
     */
    public function customErrors($errors_array);

    /**
     *
     * @param string $error_file
     * @return array
     * @throws ValidatorException
     */
    public function getErrors($lang = null);

    /**
     *
     * @return boolean
     */
    public function has($input_name, $rule_name = null);

    /**
     * @return array
     */
    public function getResults();

    /**
     *
     * @param Array $inputs
     * @param Array $rules
     * @param Array $naming
     * @return Validator
     * @throws ValidatorException
     */
    public static function validate($inputs, $rules, $naming = null);
}
