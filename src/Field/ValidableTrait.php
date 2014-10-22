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

use nkm\RedsysVirtualPos\Validation\Validator;
use \nkm\RedsysVirtualPos\Util\Helper;

/**
 * Provides validation methods to a field
 *
 * @package    Redsys Virtual POS
 * @author     Javier Zapata <javierzapata82@gmail.com>
 * @copyright  2014 Javier Zapata <javierzapata82@gmail.com>
 * @license    http://www.opensource.org/licenses/BSD-3-Clause  The BSD 3-Clause License
 * @link       http://github.com/nkm/redsys-virtual-pos
 */
trait ValidableTrait
{
    /**
     * List of predefined rules that the value must pass
     * @var array
     */
    protected $validationRules;

    /**
     * List of all the errors generated in the validation
     * @var array
     */
    protected $validationErrors;

    /**
     * @var boolean
     */
    protected $isValid;

    /**
     * @param mixed $value
     * @return FieldInterface
     */
    public function setValue($value)
    {
        $this->isValid = null;
        $this->validationErrors = null;

        $this->value = Helper::stringify($value);

        return $this;
    }

    /**
     * @return string
     */
    abstract public function getValue();

    /**
     * @return array
     */
    protected function getValidationRules()
    {
        return (array) $this->validationRules;
    }

    /**
     * Returns all the errors found on the field's validation
     * performing it if necessary
     * @return array
     */
    public function getValidationErrors()
    {
        if (is_null($this->validationErrors)) {
            $this->validate();
        }

        return $this->validationErrors;
    }

    /**
     * Returns the result of the field's validation
     * performing it if necessary
     * @return boolean
     */
    public function getIsValid()
    {
        if (is_null($this->isValid)) {
            $this->validate();
        }

        return $this->isValid;
    }

    /**
     * @return FieldInterface
     */
    protected function validate()
    {
        $fieldName = $this->getName();
        $validation = Validator::validate(
            [$fieldName => $this->getValue()],
            [$fieldName => $this->getValidationRules()]
        );

        $this->isValid          = (bool)  $validation->isSuccess();
        $this->validationErrors = (array) $validation->getErrors();

        return $this;
    }
}
