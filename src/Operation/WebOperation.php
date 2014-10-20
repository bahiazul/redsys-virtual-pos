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
class WebOperation extends AbstractOperation
{
    /**
     * @param object $environment       The environment to set
     * @param array  $requestParams     Assoc. array with all the params and values
     * @param array  $responseParams    Assoc. array with all the params and values
     */
    public function __construct($environment, $requestParams = [], $responseParams = [])
    {
        parent::__construct($environment, $requestParams, $responseParams);

        $this->endpoint = '/sis/realizarPago';

        $this->requestFields = [
            'amount'             => 'Ds_Merchant_Amount',
            'authorisationCode'  => 'Ds_Merchant_AuthorisationCode',
            'consumerLanguage'   => 'Ds_Merchant_ConsumerLanguage',
            'currency'           => 'Ds_Merchant_Currency',
            'merchantCode'       => 'Ds_Merchant_MerchantCode',
            'merchantData'       => 'Ds_Merchant_MerchantData',
            'merchantName'       => 'Ds_Merchant_MerchantName',
            'merchantSignature'  => 'Ds_Merchant_MerchantSignature',
            'titular'            => 'Ds_Merchant_Titular',
            'merchantUrl'        => 'Ds_Merchant_MerchantURL',
            'order'              => 'Ds_Merchant_Order',
            'productDescription' => 'Ds_Merchant_ProductDescription',
            'terminal'           => 'Ds_Merchant_Terminal',
            'urlKo'              => 'Ds_Merchant_UrlOK',
            'urlOk'              => 'Ds_Merchant_UrlKO',
            'transactionType'    => 'Ds_Merchant_TransactionType',
        ];

        $this->requestSignatureFields = [
            'amount',
            'order',
            'merchantCode',
            'currency',
            'transactionType',
            'merchantUrl',
        ];

        $this->responseFields = [
            'date'              => 'Ds_Date',
            'hour'              => 'Ds_Hour',
            'amount'            => 'Ds_Amount',
            'currency'          => 'Ds_Currency',
            'order'             => 'Ds_Order',
            'merchantCode'      => 'Ds_MerchantCode',
            'terminal'          => 'Ds_Terminal',
            'signature'         => 'Ds_Signature',
            'response'          => 'Ds_Response',
            'transactionType'   => 'Ds_TransactionType',
            'securePayment'     => 'Ds_SecurePayment',
            'merchantData'      => 'Ds_MerchantData',
            'cardCountry'       => 'Ds_Card_Country',
            'authorisationCode' => 'Ds_AuthorisationCode',
            'consumerLanguage'  => 'Ds_ConsumerLanguage',
            'cardType'          => 'Ds_Card_Type',
        ];

        $this->responseSignatureFields = [
            'amount',
            'order',
            'merchantCode',
            'currency',
            'response',
        ];
    }

    /**
     * Builds the HTML form for the request
     * @param  array $attributes Assoc. array of attrs for the <form> tag
     * @param  string $appendHtml HTML code to append (eg. a submit button)
     * @return string
     */
    public function getRequestForm($attributes = [], $appendHtml = '')
    {
        $attributes['method'] = 'post';
        $attributes['action'] = $this->getEndpoint();
        isset($attributes['name']) || $attributes['name'] = 'redsysOperation';

        $attributeString = '';
        foreach ($attributes as $name => $value) {
            $attributeString .= " {$name}='{$value}'";
        }

        $fields = '';
        $requestParams = $this->getRequestParams();
        foreach ($requestParams as $name => $value) {
            $fields .= "<input type='hidden' name='{$name}' value='{$value}'>\n";
        }

        $form  = "<form {$attributeString}>\n";
        $form .= $fields;
        $form .= $appendHtml ? $appendHtml . "\n" : '';
        $form .= "</form>\n";

        return $form;
    }
}
