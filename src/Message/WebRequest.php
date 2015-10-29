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

use nkm\RedsysVirtualPos\Environment\EnvironmentInterface;
use nkm\RedsysVirtualPos\Util\Helper;
use Psr\Log\LoggerInterface;

/**
 * Request for a monetary operation through a HTML form
 *
 * @package    Redsys Virtual POS
 * @author     Javier Zapata <javierzapata82@gmail.com>
 * @copyright  2014 Javier Zapata <javierzapata82@gmail.com>
 * @license    http://www.opensource.org/licenses/BSD-3-Clause  The BSD 3-Clause License
 * @link       http://github.com/nkm/redsys-virtual-pos
 */
class WebRequest extends Request implements MessageInterface
{
    /**
     * @var string
     */
    protected $endpoint = '/sis/realizarPago';

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
     * Holds all the envelop field objects
     *
     * @var array
     */
    private $envelopParams = [];

    /**
     * @param EnvironmentInterface  $environment    The environment to set
     */
    public function __construct(EnvironmentInterface $environment, LoggerInterface $logger = null)
    {
        parent::__construct($environment, $logger);

        $this->fields = array_merge($this->fields, [
            'MerchantURL',
            'UrlOK',
            'UrlKO',
            'ProductDescription',
            'Titular',
            'MerchantName',
            'ConsumerLanguage',
            'MerchantData',
            'AuthorisationCode',
        ]);
    }

    /**
     * @return string   Endpoint's full URI
     */
    public function getEndpoint()
    {
        return $this->environment->getEndpoint($this->endpoint);
    }

    /**
     * @return array All the fields that can go in an action
     */
    protected function getEnvelopFields()
    {
        return (array) $this->envelopFields;
    }

    public function setParam($fieldName, $value)
    {
        parent::setParam($fieldName, $value);

        $mp = $this->generateMerchantParameters();
        $this->setEnvelopParam('MerchantParameters', $mp);
    }

    /**
     * @param array $params     Params and values
     * @return MessageInterface
     */
    public function setEnvelopParams(Array $params)
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
        $fieldClass = $this->resolveFieldClassName($fieldName);

        try {
            $rc = new \ReflectionClass($fieldClass);
            $this->envelopParams[$fieldClass] = $rc->newInstanceArgs([$value]);
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

        if (!isset($this->envelopParams[$fieldClass]) || !is_object($this->envelopParams[$fieldClass])) {
            $rc = new \ReflectionClass($fieldClass);
            $this->envelopParams[$fieldClass] = $rc->newInstance();
        }

        return $this->envelopParams[$fieldClass];
    }

    /**
     * @return string The value of the MerchantParameters field
     */
    protected function generateMerchantParameters()
    {
        $paramsObj = $this->getParams();

        $params = [];
        foreach($paramsObj as $p) {
            $value = $p->getValue();
            if (is_null($value)) continue;

            $name  = $p->getRequestName();
            $params[$name] = $p->getValue();
        }

        $pm = json_encode($params);
        $pm = base64_encode($pm);

        try {
            $secret = $this->environment->getSecret();
            $order  = $this->getParam('Order')->getValue();

            $signature = $this->generateSignature($secret, $order, $pm);
            $this->setEnvelopParam('Signature', $signature);
        } catch (Exception $e) {
            throw new \RuntimeException($e->getMessage());
        }

        return $pm;
    }

    /**
     * @return string The encrypted signature
     */
    protected function generateSignature($secret, $order, $merchantParameters)
    {
        $key = base64_decode($secret);
        $key = Helper::mcrypt_encrypt_3DES($order, $key);

        $sig = Helper::hash_hmac_sha256($merchantParameters, $key);
        $sig = base64_encode($sig);

        return $sig;
    }

    /**
     * Builds the HTML form for the request
     *
     * @param  array    $attributes     Assoc. array of attrs for the <form> tag
     * @param  string   $appendHtml     HTML code to append (eg. a submit button)
     * @return string
     */
    public function getForm($attributes = [], $appendHtml = '')
    {
        $endpoint = $this->getEndpoint();

        $fields = '';
        $params = $this->getEnvelopParams();
        foreach ($params as $name => $param) {
            $value = $param->getValue();

            if (is_null($value)) continue;

            $requestName = $param->getRequestName();
            $fields .= "<input type='hidden' name='{$requestName}' value='{$value}'>\n";
        }

        $attributes['method'] = 'post';
        $attributes['action'] = $endpoint;
        isset($attributes['name']) || $attributes['name'] = 'redsysOperation';

        $attributeString = '';
        foreach ($attributes as $name => $value) {
            $attributeString .= " {$name}='{$value}'";
        }

        $form  = "<form{$attributeString}>\n";
        $form .= $fields;
        $form .= $appendHtml ? $appendHtml . "\n" : '';
        $form .= "</form>\n";

        return $form;
    }
}
