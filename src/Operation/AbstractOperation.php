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

namespace nkm\RedsysVirtualPos\Operation;

/**
 * A single monetary operation
 *
 * @package    Redsys Virtual POS
 * @author     Javier Zapata <javierzapata82@gmail.com>
 * @copyright  2014 Javier Zapata <javierzapata82@gmail.com>
 * @license    http://www.opensource.org/licenses/BSD-3-Clause  The BSD 3-Clause License
 * @link       http://github.com/nkm/redsys-virtual-pos
 */
abstract class AbstractOperation
{
    /**
     * @var string
     */
    protected $endpoint;

    /**
     * Environment object
     * @var object
     */
    protected $environment;

    /**
     * All the fields that can go in a request
     * @var array
     */
    protected $requestFields;

    /**
     * Fields that comprise the request signature
     * @var array
     */
    protected $requestSignatureFields;

    /**
     * Holds all the request field objects
     * @var array
     */
    protected $requestParams = [];

    /**
     * @var boolean
     */
    protected $isValidRequest;

    /**
     * @var array
     */
    protected $requestValidationErrors;

    /**
     * All the fields that can come in a response
     * @var array
     */
    protected $responseFields;

    /**
     * Fields that comprise the request signature
     * @var array
     */
    protected $responseSignatureFields;

    /**
     * Holds all the request field objects
     * @var array
     */
    protected $responseParams = [];

    /**
     * @var boolean
     */
    protected $isValidResponse;

    /**
     * @var array
     */
    protected $responseValidationErrors;

    /**
     * @param object $environment       The environment to set
     * @param array  $requestParams     Assoc. array with params and values
     * @param array  $responseParams    Assoc. array with params and values
     */
    public function __construct($environment, $requestParams = [], $responseParams = [])
    {
        $this->setEnvironment($environment);
        $this->setRequestParams($requestParams);
        $this->setResponseParams($responseParams);
    }

    /**
     * @param  string   $name
     * @param  array    $arguments
     * @throws BadMethodCallException If the method is not valid
     */
    public function __call($name, $arguments)
    {
        $pattern = '/^(set|get)(Request|Response)([a-zA-Z]+)$/';
        if (preg_match($pattern, $name) !== 1) {
            throw new \BadMethodCallException("Method `{$name}()` does not exists.");
        }

        preg_match_all($pattern, $name, $matches, PREG_SET_ORDER);
        list(, $action, $type, $fieldName) = $matches[0];

        $methodName = $action.$type.'Param';
        if ($action === 'set') {
            $this->{$methodName}($fieldName, $arguments[0]);

            return $this;
        }

        if ($action === 'get') {
            return $this->{$methodName}($fieldName);
        }
    }

    /**
     * @return array All the fields that can go in a request
     */
    protected function getRequestFields()
    {
        return (array) $this->requestFields;
    }

    /**
     * @return array All the fields that comprise the request signature
     */
    protected function getRequestSignatureFields()
    {
        return (array) $this->requestSignatureFields;
    }

    /**
     * @param array $requestParams Assoc. array with all the params and values
     * @return AbstractOperation
     */
    public function setRequestParams(Array $requestParams)
    {
        foreach ($requestParams as $paramName => $paramValue) {
            $methodName = 'setRequest'.ucfirst($paramName);
            $this->{$methodName}($paramValue);
        }

        return $this;
    }

    /**
     * @return array The request's parameter objects
     */
    public function getRequestParams()
    {
        $requestParams = [];
        $requestFields = $this->getRequestFields();
        foreach ($requestFields as $fieldKey => $fieldName) {
            $methodName = 'getRequest'.ucfirst($fieldKey);
            $fieldObj   = $this->{$methodName}();

            // if (strval($fieldObj) === '') {
            //     continue;
            // }

            $requestParams[$fieldName] = $fieldObj;
        }

        return $requestParams;
    }

    /**
     * @param string $fieldName The field's name
     * @param mixed  $value     The field's value
     * @return AbstractOperation
     */
    private function setRequestParam($fieldName, $value)
    {
        $this->isValidRequest = null;
        $this->requestValidationErrors = null;

        $fieldKey   = lcfirst($fieldName);
        $fieldClass = $this->getFieldClassName($fieldName);

        $this->ensureClassExists($fieldClass);

        $rc = new \ReflectionClass($fieldClass);
        $this->requestParams[$fieldKey] = $rc->newInstanceArgs([$value]);

        return $this;
    }

    /**
     * @param string $fieldName The field's name
     * @return FieldInterface
     */
    private function getRequestParam($fieldName)
    {
        $fieldKey  = lcfirst($fieldName);
        $fieldClass = $this->getFieldClassName($fieldName);

        $this->ensureClassExists($fieldClass);

        if (!isset($this->requestParams[$fieldKey]) || !is_object($this->requestParams[$fieldKey])) {
            $rc = new \ReflectionClass($fieldClass);
            $this->requestParams[$fieldKey] = $rc->newInstance();
        }

        return $this->requestParams[$fieldKey];
    }

    /**
     * @param mixed $value The Amount's value
     * @return AbstractOperation
     */
    public function setRequestAmount($value)
    {
        $detector = new \CurrencyDetector\Detector();

        $currencies = $detector->getCurrencies($value);
        if (is_array($currencies)) {
            $currencyClass = $this->getFieldClassName('Currency');
            foreach ($currencies as $code) {
                $constantName = $currencyClass.'::'.$code;

                if (!defined($constantName)) {
                    continue;
                }

                $key = constant($constantName);
                $this->setRequestCurrency($key);
                break;
            }
        }

        $this->isValidRequest = null;
        $this->requestValidationErrors = null;

        $amount = $detector->getAmount($value);
        $amtClass = $this->getFieldClassName('Amount');
        $this->requestParams['amount'] = new $amtClass($amount);

        return $this;
    }

    /**
     * @return Amount
     */
    public function getRequestAmount()
    {
        $amount   = $this->getRequestParam('amount');
        $currency = $this->getRequestCurrency();

        if (is_null($amount) || empty(strval($amount))) {
            return $amount;
        }

        $currencyClass = $this->getFieldClassName('Currency');
        if ($currency->getValue() !== $currencyClass::JPY) {
            $amount = floatval(strval($amount));
            $amount = $amount * 100;
        }

        $amount   = intval(strval($amount));
        $amtClass = $this->getFieldClassName('Amount');

        return new $amtClass($amount);
    }

    /**
     * Generate and return the encripted Merchant's signature
     * @return MerchantSignature
     */
    public function getRequestMerchantSignature()
    {
        $signature = $this->generateSignature('request');
        $this->setRequestParam('merchantSignature', $signature);

        return $this->getRequestParam('merchantSignature');
    }

    /**
     * Returns all the errors found on the field's validation
     * performing it if necessary
     * @return array List of validation error messages
     */
    public function getRequestValidationErrors()
    {
        if (is_null($this->requestValidationErrors)) {
            $this->validateRequest();
        }

        return $this->requestValidationErrors;
    }

    /**
     * Returns the result of the field's validation
     * performing it if necessary
     * @return boolean
     */
    public function getIsValidRequest()
    {
        if (is_null($this->isValidRequest)) {
            $this->validateRequest();
        }

        return $this->isValidRequest;
    }

    /**
     * Validates all the params of the request
     * @return AbstractOperation
     */
    protected function validateRequest()
    {
        $isValidRequest = null;
        $requestValidationErrors = [];
        $requestParams = $this->getRequestParams();
        foreach ($requestParams as $param) {
            if (is_null($isValidRequest) || $isValidRequest === true) {
                $isValidRequest = $param->getIsValid();
            }

            $requestValidationErrors = array_merge(
                $requestValidationErrors,
                $param->getValidationErrors()
            );
        }

        $this->isValidRequest          = (bool) $isValidRequest;
        $this->requestValidationErrors = $requestValidationErrors;

        return $this;
    }

    /**
     * @return array All the fields that can come in a response
     */
    protected function getResponseFields()
    {
        return (array) $this->responseFields;
    }

    /**
     * @return array All the fields that comprise the response signature
     */
    protected function getResponseSignatureFields()
    {
        return (array) $this->responseSignatureFields;
    }

    /**
     * @param array $responseParams Assoc. array with all the params and values
     * @return AbstractOperation
     */
    public function setResponseParams(Array $responseParams)
    {
        foreach ($responseParams as $paramName => $value) {
            $fieldName = array_search($paramName, $this->responseFields);

            if ($fieldName === false) {
                continue;
            }

            $this->setResponseParam($fieldName, $value);
        }

        return $this;
    }

    /**
     * @return array The response's parameter objects
     */
    public function getResponseParams()
    {
        $responseParams = [];
        $responseFields = $this->getResponseFields();
        foreach ($responseFields as $fieldKey => $fieldName) {
            $methodName = 'getResponse'.ucfirst($fieldKey);
            $value      = $this->{$methodName}();

            $responseParams[$fieldKey] = $value;
        }

        return $responseParams;
    }

    /**
     * @param string $fieldName The field's name
     * @param mixed  $value     The field's value
     * @return AbstractOperation
     */
    private function setResponseParam($fieldName, $value)
    {
        $fieldKey   = lcfirst($fieldName);
        $fieldClass = $this->getFieldClassName($fieldKey);

        $this->ensureClassExists($fieldClass);

        $rc = new \ReflectionClass($fieldClass);
        $this->responseParams[$fieldKey] = $rc->newInstanceArgs([$value]);

        return $this;
    }

    /**
     * @param string $fieldName The field's name
     * @return FieldInterface
     */
    private function getResponseParam($fieldName)
    {
        $fieldKey = lcfirst($fieldName);

        if (!isset($this->responseParams[$fieldKey])) {
            return null;
        }

        return $this->responseParams[$fieldKey];
    }

    /**
     * Returns all the errors found on the field's validation
     * performing it if necessary
     * @return array List of validation error messages
     */
    public function getResponseValidationErrors()
    {
        if (is_null($this->responseValidationErrors)) {
            $this->validateResponse();
        }

        return $this->responseValidationErrors;
    }

    /**
     * Returns the result of the field's validation
     * performing it if necessary
     * @return boolean
     */
    public function getIsValidResponse()
    {
        if (is_null($this->isValidResponse)) {
            $this->validateResponse();
        }

        return $this->isValidResponse;
    }

    /**
     * Validates the response's signature and the fields in common with the request
     * @return AbstractOperation
     */
    protected function validateResponse()
    {
        $isValidResponse = null;
        $responseValidationErrors = [];

        // Validate the signature
        $checkSignature    = $this->generateSignature('response');
        $responseSignature = $this->getResponseSignature();

        $areEqual = ($responseSignature->getValue() === $checkSignature);
        $isValidResponse = $areEqual;
        $areEqual || $responseValidationErrors[] = 'Response Signature is not valid';

        // Validate those response fields that should match with their request counterparts
        $fieldKeys = ['amount', 'currency', 'order', 'merchantCode', 'terminal', 'transactionType'];
        foreach ($fieldKeys as $fieldKey) {
            $fieldName = ucfirst($fieldKey);
            $requestFieldObj  = $this->{'getRequest'.$fieldName}();
            $responseFieldObj = $this->{'getResponse'.$fieldName}();

            $areEqual = ($responseFieldObj->getValue() === $requestFieldObj->getValue());

            if (is_null($isValidResponse) || $isValidResponse === true) {
                $isValidResponse = $areEqual;
            }

            $areEqual || $responseValidationErrors[] = "Request and Response {$fieldName} parameters do not match";
        }

        $this->isValidResponse          = (bool) $isValidResponse;
        $this->responseValidationErrors = $responseValidationErrors;

        return $this;
    }

    /**
     * @param  object $environment The environment to set
     * @return AbstractOperation
     */
    public function setEnvironment($environment)
    {
        $this->environment = $environment;

        return $this;
    }

    /**
     * @return object The current environment
     */
    public function getEnvironment()
    {
        $this->ensureValidEnvironment($this->environment);

        return $this->environment;
    }

    /**
     * Get the full endpoint URI
     * @return string Endpoint's URI
     */
    public function getEndpoint()
    {
        $environment = $this->getEnvironment();

        return $environment->getEndpoint($this->endpoint);
    }

    /**
     * @param  string $type   request|response
     * @return string         The encrypted signature
     */
    private function generateSignature($type)
    {
        $environment = $this->getEnvironment();

        try {
            $secret = $environment->getSecret();
        } catch (Exception $e) {
            throw new OperationException("Cannot generate the signature. Merchant secret is not set.");
        }

        $type === 'response' || $type = 'request';
        $type = ucfirst($type);
        $fields = $this->{'get'.$type.'SignatureFields'}();
        ksort($fields, SORT_NUMERIC);

        $signaturePlain = '';
        foreach($fields as $fieldKey) {
            $methodName      = 'get'.$type.ucfirst($fieldKey);
            $fieldObj        = $this->{$methodName}();
            $signaturePlain .= $fieldObj;
        }
        $signaturePlain .= $secret;

        $signatureCrypt = strtoupper(sha1($signaturePlain));

        return $signatureCrypt;
    }

    /**
     * Get the fully qualified name of a field's class
     * @param  string $fieldName The field name
     * @return string            The field class name
     */
    private function getFieldClassName($fieldName)
    {
        return '\nkm\RedsysVirtualPos\Field\\'.$fieldName;
    }

    /**
     * Checks if the given environment inherits from the base one
     * @param  object $environment The environment to check
     * @return void
     * @throws Exception If the environment is not valid
     */
    private function ensureValidEnvironment($environment)
    {
        $ae = '\nkm\RedsysVirtualPos\Environment\AbstractEnvironment';
        if (!is_subclass_of($environment, $ae)) {
            throw new OperationException("The supplied environment is not valid.");
        }
    }

    /**
     * Validates the existence of a given class
     * @param  string $className The fully qualified name of the class
     * @throws Exception If the class does not exist
     */
    private function ensureClassExists($className)
    {
        if (!class_exists($className)) {
            throw new OperationException("`{$className}` does not exists.");
        }
    }
}
