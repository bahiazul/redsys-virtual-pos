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
class XmlOperation extends AbstractOperation
{
    /**
     * @param object $environment       The environment to set
     * @param array  $requestParams     Assoc. array with all the params and values
     * @param array  $responseParams    Assoc. array with all the params and values
     */
    public function __construct($environment, $requestParams = [], $responseParams = [])
    {
        parent::__construct($environment, $requestParams, $responseParams);

        $this->endpoint = '/sis/operaciones';

        $this->requestFields = [
            'amount'             => 'DS_MERCHANT_AMOUNT',
            'currency'           => 'DS_MERCHANT_CURRENCY',
            'order'              => 'DS_MERCHANT_ORDER',
            'merchantCode'       => 'DS_MERCHANT_MERCHANTCODE',
            'merchantUrl'        => 'DS_MERCHANT_MERCHANTURL',
            'merchantName'       => 'DS_MERCHANT_MERCHANTNAME',
            'consumerLanguage'   => 'DS_MERCHANT_CONSUMERLANGUAGE',
            'merchantSignature'  => 'DS_MERCHANT_MERCHANTSIGNATURE',
            'terminal'           => 'DS_MERCHANT_TERMINAL',
            'transactionType'    => 'DS_MERCHANT_TRANSACTIONTYPE',
            'merchantData'       => 'DS_MERCHANT_MERCHANTDATA',
            'pan'                => 'DS_MERCHANT_PAN',
            'expiryDate'         => 'DS_MERCHANT_EXPIRYDATE',
            'authorisationCode'  => 'DS_MERCHANT_AUTHORISATIONCODE',
            'transactionDate'    => 'DS_MERCHANT_TRANSACTIONDATE',
            'cvv2'               => 'DS_MERCHANT_CVV2',
        ];

        $this->requestSignatureFields = [
            'amount',
            'order',
            'merchantCode',
            'currency',
            'pan',
            'cvv2',
            'transactionType',
            'merchantSecret',
        ];

        $this->responseFields = [
            'amount'            => 'Ds_Amount',
            'currency'          => 'Ds_Currency',
            'order'             => 'Ds_Order',
            'signature'         => 'Ds_Signature',
            'merchantCode'      => 'Ds_MerchantCode',
            'terminal'          => 'Ds_Terminal',
            'response'          => 'Ds_Response',
            'authorisationCode' => 'Ds_AuthorisationCode',
            'transactionType'   => 'Ds_TransactionType',
            'merchantData'      => 'Ds_MerchantData',
            'securePayment'     => 'Ds_SecurePayment',
            'reference'         => 'Ds_Reference',
            'language'          => 'Ds_Language',
            'cardNumber'        => 'Ds_CardNumber',
            'expiryDate'        => 'Ds_ExpiryDate',
        ];

        $this->responseSignatureFields = [
            'amount',
            'order',
            'merchantCode',
            'currency',
            'response',
            'cardNumber',
            'transactionType',
            'securePayment',
            'merchantSecret',
        ];
    }

    //     __ _  __    _  __    _  _  _  __ _     __
    // |_||_ |_)|_    |_)|_    | \|_)|_|/__/ \|\|(_
    // | ||__| \|__   |_)|__   |_/| \| |\_|\_/| |__)
}
