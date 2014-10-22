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

namespace nkm\RedsysVirtualPos\Util;

/**
 * Static helpers
 *
 * @package    Redsys Virtual POS
 * @author     Javier Zapata <javierzapata82@gmail.com>
 * @copyright  2014 Javier Zapata <javierzapata82@gmail.com>
 * @license    http://www.opensource.org/licenses/BSD-3-Clause  The BSD 3-Clause License
 * @link       http://github.com/nkm/redsys-virtual-pos
 */
class Helper
{
    /**
     * Converts any variable into a string without raising Errors, Notices or
     * getting weird results (like "Array")
     *
     * @param  mixed $var
     * @return string
     */
    public static function stringify($var)
    {
        if (is_array($var) || (is_object($var) && !method_exists($var, '__toString'))) {
            $var = '';
        } elseif (!is_string($var)) {
            $var = strval($var);
        }

        return $var;
    }
}
