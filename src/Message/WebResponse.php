<?php
/**
 * Redsys Virtual POS
 *
 * @package    Redsys Virtual POS
 * @author     Javier Zapata <javierzapata82@gmail.com>
 * @copyright  2020 Javier Zapata <javierzapata82@gmail.com>
 * @license    https://www.opensource.org/licenses/BSD-3-Clause  The BSD 3-Clause License
 * @link       https://github.com/jzfgo/redsys-virtual-pos
 */

namespace nkm\RedsysVirtualPos\Message;

use nkm\RedsysVirtualPos\Environment\EnvironmentInterface;
use nkm\RedsysVirtualPos\Util\Helper;
use Psr\Log\LoggerInterface;

/**
 * Response of a monetary operation requested through a HTML form
 *
 * @package    Redsys Virtual POS
 * @author     Javier Zapata <javierzapata82@gmail.com>
 * @copyright  2020 Javier Zapata <javierzapata82@gmail.com>
 * @license    https://www.opensource.org/licenses/BSD-3-Clause  The BSD 3-Clause License
 * @link       https://github.com/jzfgo/redsys-virtual-pos
 */
class WebResponse extends Response implements MessageInterface
{
    /**
     * The prefix for the names of the received params
     *
     * @var string
     */
    protected $fieldPrefix = 'Ds_';

    /**
     * Holds all the envelop field names
     *
     * @var array
     */
    private $envelopFields = [
        'SignatureVersion',
        'MerchantParameters',
        'Signature',
    ];

    /**
     * Holds all the field objects
     *
     * @var array
     */
    private $envelopParams = [];

    /**
     * @return array All the fields that can go in an action
     */
    protected function getEnvelopFields()
    {
        return (array) $this->envelopFields;
    }

    /**
     * @param array $params     Params and values
     * @return MessageInterface
     */
    public function setEnvelopeParams(Array $params)
    {
        foreach ($params as $paramName => $paramValue) {
            $this->setEnvelopParam($paramName, $paramValue);
        }

        return $this;
    }

    /**
     * @return array The actions's parameter objects
     */
    public function getEnvelopParams()
    {
        $params = [];
        $fields = $this->getEnvelopFields();
        foreach ($fields as $fieldName) {
            $params[$fieldName] = $this->getEnvelopParam($fieldName);
        }

        return $params;
    }

    /**
     * @param  string   $fieldName  The field's name
     * @param  mixed    $value      The field's value
     * @return MessageInterface
     */
    protected function setEnvelopParam($fieldName, $value)
    {
        try {
            $fieldClass = $this->resolveFieldClassName($fieldName);
            $rc = new \ReflectionClass($fieldClass);
            $shortName = $rc->getShortName();

            $this->envelopParams[$shortName] = $rc->newInstanceArgs([$value]);

            if ($this->envelopParams[$shortName]->getName() === 'MerchantParameters') {
                $params = $this->decodeMerchantParameters($value);
                $this->setParams($params);
            }

        } catch (Exception $e) {
            throw new \RuntimeException("Class `{$fieldClass}` not found.");
        }

        return $this;
    }

    /**
     * @param string $fieldName The field's name
     * @return FieldInterface
     */
    protected function getEnvelopParam($fieldName)
    {
        $fieldClass = $this->resolveFieldClassName($fieldName);
        $rc = new \ReflectionClass($fieldClass);
        $shortName = $rc->getShortName();

        if (!isset($this->envelopParams[$shortName]) || !is_object($this->envelopParams[$shortName])) {
            $this->envelopParams[$shortName] = $rc->newInstance();
        }

        return $this->envelopParams[$shortName];
    }

    /**
     * Decode the contents of the MerchantParameters field
     *
     * @param  string   $value  The field's value
     * @return array            The parameters that comprise the field's contents
     */
    private function decodeMerchantParameters($value)
    {
        $errorMsg = "MerchantParameters field could not be decoded";
        $value = Helper::base64url_decode($value);

        if ($value === false) {
            throw new \RuntimeException($errorMsg.' (base64url).');
        }

        $value = json_decode($value, true);

        if (is_null($value)) {
            throw new \RuntimeException($errorMsg.' (JSON).');
        }

        is_array($value) || $value = [];

        return $value;
    }

    /**
     * @return string The encrypted signature
     */
    protected function generateSignature($secret, $order, $merchantParameters)
    {
        $key = Helper::base64url_decode($secret);
        $key = Helper::mcrypt_encrypt_3DES($order, $key);

        $sig = Helper::hash_hmac_sha256($merchantParameters, $key);
        $sig = Helper::base64url_encode($sig);

        return $sig;
    }

    /**
     * Validates all the params of the request
     *
     * @return MessageInterface
     */
    protected function validate()
    {
        $isValid = true;
        $validationErrors = [];

        try {
            $secret = $this->environment->getSecret();
            $order  = $this->getParam('Order')->getValue();
            $mp     = $this->getEnvelopParam('MerchantParameters')->getValue();

            $chkSignature = $this->generateSignature($secret, $order, $mp);
            $resSignature = $this->getEnvelopParam('Signature')->getValue();
        } catch (Exception $e) {
            throw new \RuntimeException($e->getMessage());
        }

        if ($resSignature !== $chkSignature) {
            $isValid = false;
            $validationErrors[] = 'La firma recibida no es correcta.';
        }

        $this->isValid          = $isValid;
        $this->validationErrors = $validationErrors;

        return $this;
    }
}
