<?php
/**
 * Redsys Virtual POS
 *
 * @package    Redsys Virtual POS
 * @author     Javier Zapata <javierzapata82@gmail.com>
 * @copyright  2021 Javier Zapata <javierzapata82@gmail.com>
 * @license    https://opensource.org/licenses/MIT The MIT License
 * @link       https://github.com/bahiazul/redsys-virtual-pos
 */

namespace Bahiazul\RedsysVirtualPos\Field;

/**
 * Holds the value of a request/response parameter
 *
 * @package    Redsys Virtual POS
 * @author     Javier Zapata <javierzapata82@gmail.com>
 * @copyright  2021 Javier Zapata <javierzapata82@gmail.com>
 * @license    https://opensource.org/licenses/MIT The MIT License
 * @link       https://github.com/bahiazul/redsys-virtual-pos
 */
class Currency extends AbstractField implements FieldInterface
{
    use ValidableTrait;

    /**
     * Indicates if this field can appear in a request
     *
     * @var boolean
     */
    protected $inRequest = true;

    /**
     * Indicates if this field can appear in a response
     *
     * @var boolean
     */
    protected $inResponse = true;

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

    /**
     * Set of predefined values
     *
     * @var array
     */
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
