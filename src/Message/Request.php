<?php
/**
 * Redsys Virtual POS
 *
 * @package    Redsys Virtual POS
 * @author     Javier Zapata <javierzapata82@gmail.com>
 * @copyright  2021 Javier Zapata <javierzapata82@gmail.com>
 * @license    https://www.opensource.org/licenses/BSD-3-Clause  The BSD 3-Clause License
 * @link       https://github.com/jzfgo/redsys-virtual-pos
 */

namespace nkm\RedsysVirtualPos\Message;

/**
 * Part of a communication for a monetary operation (a request or a reponse)
 *
 * @package    Redsys Virtual POS
 * @author     Javier Zapata <javierzapata82@gmail.com>
 * @copyright  2021 Javier Zapata <javierzapata82@gmail.com>
 * @license    https://www.opensource.org/licenses/BSD-3-Clause  The BSD 3-Clause License
 * @link       https://github.com/jzfgo/redsys-virtual-pos
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
        'Amount',
        'Order',
        'MerchantCode',
        'Currency',
        'TransactionType',
        'Terminal',
    ];

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
