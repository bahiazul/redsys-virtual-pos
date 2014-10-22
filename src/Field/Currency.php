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

namespace nkm\RedsysVirtualPos\Field;

/**
 * Holds the value of a request/response parameter
 *
 * @package    Redsys Virtual POS
 * @author     Javier Zapata <javierzapata82@gmail.com>
 * @copyright  2014 Javier Zapata <javierzapata82@gmail.com>
 * @license    http://www.opensource.org/licenses/BSD-3-Clause  The BSD 3-Clause License
 * @link       http://github.com/nkm/redsys-virtual-pos
 */
class Currency extends AbstractField implements FieldInterface
{
    use ValidableTrait;

    protected $name         = 'Currency';
    protected $requestName  = 'Ds_Merchant_Currency';
    protected $responseName = 'Ds_Currency';

    const EUR = '978';
    const USD = '840';
    const GBP = '826';
    const JPY = '392';
    const ARS = '32';
    const CAD = '124';
    const CLP = '152';
    const COP = '170';
    const INR = '356';
    const MXN = '484';
    const PEN = '604';
    const CHF = '756';
    const BRL = '986';
    const VEF = '937';
    const TRL = '949';

    protected static $availableValues = [
        self::EUR => 'Euro',
        self::USD => 'Dólar',
        self::GBP => 'Libra Esterlina',
        self::JPY => 'Yen',
        self::ARS => 'Peso Argentino',
        self::CAD => 'Dólar Canadiense',
        self::CLP => 'Peso Chileno',
        self::COP => 'Peso Colombiano',
        self::INR => 'Rupia India',
        self::MXN => 'Nuevo Peso Mejicano',
        self::PEN => 'Nuevos Soles',
        self::CHF => 'Franco Suizo',
        self::BRL => 'Real Brasileño',
        self::VEF => 'Bolívar Venezolano',
        self::TRL => 'Lira Turca',
    ];

    /**
     * @param mixed $value
     */
    public function __construct($value = null)
    {
        parent::__construct($value);

        $this->defaultValue = self::EUR;

        $keys = serialize(array_keys(self::getAvailableValues()));

        $this->validationRules = [
            'required',
            "in_array({$keys})",
        ];
    }
}
