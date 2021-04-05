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
class Language extends AbstractField implements FieldInterface
{
    const CLI = '0';
    const SPA = '1';
    const ENG = '2';
    const CAT = '3';
    const FRA = '4';
    const DEU = '5';
    const NLD = '6';
    const ITA = '7';
    const SWE = '8';
    const POR = '9';
    const VAL = '10';
    const POL = '11';
    const GLG = '12';
    const EUS = '13';

    /**
     * Set of predefined values
     *
     * @var array
     */
    protected static $availableValues = [
        self::CLI => 'Cliente',
        self::SPA => 'Castellano',
        self::ENG => 'Inglés',
        self::CAT => 'Catalán',
        self::FRA => 'Francés',
        self::DEU => 'Alemán',
        self::NLD => 'Neerlandés',
        self::ITA => 'Italiano',
        self::SWE => 'Sueco',
        self::POR => 'Portugués',
        self::VAL => 'Valenciano',
        self::POL => 'Polaco',
        self::GLG => 'Gallego',
        self::EUS => 'Euskera',
    ];

    /**
     * @param mixed $value
     */
    public function __construct($value = null)
    {
        parent::__construct($value);

        $keys = serialize(array_keys(self::getAvailableValues()));

        $this->validationRules = [
            "in_array({$keys})",
        ];
    }
}
