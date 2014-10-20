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

namespace nkm\RedsysVirtualPos\Environment;

use \nkm\RedsysVirtualPos\Util\Helper;

/**
 * Handles environment-specific information
 *
 * @package    Redsys Virtual POS
 * @author     Javier Zapata <javierzapata82@gmail.com>
 * @copyright  2014 Javier Zapata <javierzapata82@gmail.com>
 * @license    http://www.opensource.org/licenses/BSD-3-Clause  The BSD 3-Clause License
 * @link       http://github.com/nkm/redsys-virtual-pos
 */
abstract class AbstractEnvironment implements EnvironmentInterface
{
    /**
     * Merchant's private key
     * @var string
     */
    protected $secret;

    /**
     * Common base URL for all the operations
     * @var string
     */
    protected $baseEndpoint;

    /**
     * @return EnvironmentInterface
     */
    final public function setSecret($secret)
    {
        $this->secret = Helper::stringify($secret);

        return $this;
    }

    /**
     * @return string       The secret key
     * @throws Exception    If secret is not set
     */
    final public function getSecret()
    {
        $secret = Helper::stringify($this->secret);

        if (empty($secret)) {
            throw new EnvironmentException("Merchant secret is not set.");
        }

        return $secret;
    }

    /**
     * @return string       Endpoint's base URL
     * @throws Exception    If the Base Endpoint is not set
     */
    final private function getBaseEndpoint()
    {
        $baseEndpoint = Helper::stringify($this->baseEndpoint);

        if (empty($baseEndpoint)) {
            throw new EnvironmentException("Environment's Base Endpoint is not set.");
        }

        return $baseEndpoint;
    }

    /**
     * @param  string $endpoint The resource path of the Endpoint
     * @return string           Endpoint's full URI
     */
    final public function getEndpoint($endpoint)
    {
        $baseEndpoint = $this->getBaseEndpoint();
        $endpoint     = Helper::stringify($endpoint);

        if (empty($endpoint)) {
            throw new \InvalidArgumentException("`{$endpoint}` is not a valid endpoint.");
        }

        return $baseEndpoint . $endpoint;
    }
}
