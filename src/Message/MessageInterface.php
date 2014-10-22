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

namespace nkm\RedsysVirtualPos\Message;

/**
 * Part of a communication for a monetary operation (a request or a reponse)
 *
 * @package    Redsys Virtual POS
 * @author     Javier Zapata <javierzapata82@gmail.com>
 * @copyright  2014 Javier Zapata <javierzapata82@gmail.com>
 * @license    http://www.opensource.org/licenses/BSD-3-Clause  The BSD 3-Clause License
 * @link       http://github.com/nkm/redsys-virtual-pos
 */
interface MessageInterface
{
    /**
     * @param array $params     Params and values
     * @return MessageInterface
     */
    public function setParams(Array $params);

    /**
     * @return array The actions's parameter objects
     */
    public function getParams();

    /**
     * Returns the result of the field's validation
     * performing it if necessary
     * @return boolean
     */
    public function getIsValid();

    /**
     * Returns all the errors found on the field's validation
     * performing it if necessary
     * @return array List of validation error messages
     */
    public function getValidationErrors();
}
