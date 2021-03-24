<?php

use \PHPUnit\Framework\TestCase;
use \nkm\RedsysVirtualPos\Validation\Validator;

class ValidatorNumericTest extends TestCase
{
    public function NumericInputProvider()
    {
        return array(
            array(array('test' => ''),                    true),
            array(array('test' => null),                  true),

            array(array('test' => 15),                    true),
            array(array('test' => 15.5),                  true),
            array(array('test' => 1.0),                   true),
            array(array('test' => .27),                   true),
            array(array('test' => 3.),                    true),
            array(array('test' => -0.0),                  true),
            array(array('test' => -1.0),                  true),
            array(array('test' => -15),                   true),
            array(array('test' => -3.),                   true),
            array(array('test' => 9e19),                  true),
            array(array('test' => -9e19),                 true),
            array(array('test' => 0123),                  true),
            array(array('test' => 0b11111111),            true),
            array(array('test' => 0x1A),                  true),

            array(array('test' => "15"),                  true),
            array(array('test' => "-15"),                 true),
            array(array('test' => "0123"),                true),
            array(array('test' => ' -0.0 '),              true),
            array(array('test' => ' 0.1 '),               true),
            array(array('test' => '+1353.0316547'),       true),
            array(array('test' => '-1.0'),                true),
            array(array('test' => '-1354.98879e+37436'),  true),
            array(array('test' => '-3.'),                 true),
            array(array('test' => '-8E+3'),               true),
            array(array('test' => '.27'),                 true),
            array(array('test' => '1.0'),                 true),
            array(array('test' => '13213.032468e-13465'), true),
            array(array('test' => '1e2'),                 true),
            array(array('test' => '2.1'),                 true),

            array(array('test' => "0b11111111"),          false),
            array(array('test' => 'whatevs'),             false),
        );
    }

    /**
     * @covers \nkm\RedsysVirtualPos\Validation\Validator::Numeric
     * @dataProvider NumericInputProvider
     */
    public function testNumeric($inputs, $expected)
    {
        $rules  = array(
            'test' => array('Numeric')
        );

        $validation_result = Validator::validate($inputs, $rules);

        $this->assertEquals($expected, $validation_result->isSuccess());
    }
}
