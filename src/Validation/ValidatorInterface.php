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

namespace nkm\RedsysVirtualPos\Validation;

/**
 * Simple Validator Class for php
 * @author Can Geliş <geliscan@gmail.com>
 * @copyright (c) 2013, Can Geliş
 * @license https://github.com/nkm/simple-validator/blob/master/licence.txt MIT Licence
 * @link https://github.com/nkm/simple-validator
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
