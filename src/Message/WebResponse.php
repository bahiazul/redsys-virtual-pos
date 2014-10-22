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
class WebResponse extends Response implements MessageInterface
{
    /**
     * @param EnvironmentInterface  $environment    The environment to set
     */
    public function __construct(EnvironmentInterface $environment)
    {
        parent::__construct($environment);

        $this->fields = array_merge($this->fields, [
            'Ds_TransactionType' => 'WebTransactionType',
        ]);
    }
}
