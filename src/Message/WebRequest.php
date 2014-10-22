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

use \nkm\RedsysVirtualPos\Environment\EnvironmentInterface;

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
     * @param EnvironmentInterface  $environment    The environment to set
     */
    public function __construct(EnvironmentInterface $environment)
    {
        parent::__construct($environment);

        $this->fields = array_merge($this->fields, [
            'authorisationCode'  => 'AuthorisationCode',
            'consumerLanguage'   => 'ConsumerLanguage',
            'merchantData'       => 'MerchantData',
            'merchantName'       => 'MerchantName',
            'titular'            => 'Titular',
            'merchantUrl'        => 'MerchantURL',
            'productDescription' => 'ProductDescription',
            'urlKo'              => 'UrlOK',
            'urlOk'              => 'UrlKO',
            'transactionType'    => 'WebTransactionType',
        ]);
    }

    /**
     * Builds the HTML form for the request
     * @param  array    $attributes     Assoc. array of attrs for the <form> tag
     * @param  string   $appendHtml     HTML code to append (eg. a submit button)
     * @return string
     */
    public function getForm($attributes = [], $appendHtml = '')
    {
        $attributes['method'] = 'post';
        isset($attributes['name']) || $attributes['name'] = 'redsysOperation';

        try {
            $attributes['action'] = $this->environment->getEndpoint($this->endpoint);
        } catch (Exception $e) {
            throw new \RuntimeException($e->getMessage());
        }

        $attributeString = '';
        foreach ($attributes as $name => $value) {
            $attributeString .= " {$name}='{$value}'";
        }

        $fields = '';
        $params = $this->getParams();
        foreach ($params as $name => $param) {
            $value       = $param->getValue();

            if ($value === '') {
                continue;
            }

            $requestName = $param->getRequestName();
            $fields .= "<input type='hidden' name='{$requestName}' value='{$value}'>\n";
        }

        $form  = "<form {$attributeString}>\n";
        $form .= $fields;
        $form .= $appendHtml ? $appendHtml . "\n" : '';
        $form .= "</form>\n";

        return $form;
    }
}
