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
     * @var array
     */
    protected $fields = [
        'amount'       => 'Amount',
        'currency'     => 'Currency',
        'merchantCode' => 'MerchantCode',
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
        'merchantCode',
        'currency',
        'transactionType',
        'merchantUrl',
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
            $fieldClass = $this->getFieldClassName('signature');
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
