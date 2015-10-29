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

namespace nkm\RedsysVirtualPos\Environment;

use nkm\RedsysVirtualPos\Util\Helper;

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
     *
     * @var string
     */
    protected $secret;

    /**
     * Common base URL for all the operations
     *
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
     * @return string
     */
    public function getName()
    {
        $className = (new \ReflectionClass($this))->getShortName();
        return strtolower(preg_replace('/Environment$/', '', $className));
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
