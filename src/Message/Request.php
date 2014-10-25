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
class Request extends AbstractMessage implements MessageInterface
{
    /**
     * @var string
     */
    protected $endpoint;

    /**
     * All the fields that can go in a request
     *
     * The array's keys should be underscore strings
     * and its values be names of classes extending
     * from AbstractField
     *
     * @var array
     */
    protected $fields = [
        'amount'       => 'Amount',
        'currency'     => 'Currency',
        'merchantcode' => 'MerchantCode',
        'order'        => 'Order',
        'terminal'     => 'Terminal',
    ];

    /**
     * Fields that comprise the signature
     * @var array
     */
    protected $signatureFields = [
        'amount',
        'order',
        'merchantcode',
        'currency',
        'transactiontype',
        'merchanturl',
    ];

    /**
     * @return array The actions's parameter objects
     */
    public function getParams()
    {
        return array_merge(parent::getParams(), [
            'signature' => $this->getParam('signature')
        ]);
    }

    /**
     * @param  string   $fieldName  The field's name
     * @param  mixed    $value      The field's value
     * @return MessageInterface
     */
    protected function setParam($fieldName, $value)
    {
        parent::setParam($fieldName, $value);

        // If the field is also part of the signature
        // we also generate it
        if (in_array($fieldName, $this->getSignatureFields())) {
            $fieldClass = $this->resolveFieldClassName('signature');
            $rc = new \ReflectionClass($fieldClass);
            $this->params['signature'] = $rc->newInstanceArgs([$this->generateSignature()]);
        }

        return $this;
    }

    /**
     * Validates all the params of the request
     * @return MessageInterface
     */
    protected function validate()
    {
        $isValid = null;
        $validationErrors = [];
        $params = $this->getParams();
        foreach ($params as $param) {
            if (is_null($isValid) || $isValid === true) {
                $isValid = $param->getIsValid();
            }

            $validationErrors = array_merge(
                $validationErrors,
                $param->getValidationErrors()
            );
        }

        $this->isValid          = (bool) $isValid;
        $this->validationErrors = $validationErrors;

        return $this;
    }
}
