<?php

class ValidatorFloatTest extends PHPUnit_Framework_TestCase
{
    public function floatInputProvider()
    {
        return array(
            array(array('test' => ''),                    true),
            array(array('test' => null),                  true),

            array(array('test' => 1.0),                   true),
            array(array('test' => -1.0),                  true),
            array(array('test' => '1.0'),                 true),
            array(array('test' => '-1.0'),                true),
            array(array('test' => '2.1'),                 true),
            array(array('test' => ' 0.1 '),               true),
            array(array('test' => ' -0.0 '),              true),
            array(array('test' => -0.0),                  true),
            array(array('test' => 3.),                    true),
            array(array('test' => -3.),                   true),
            array(array('test' => '-3.'),                 true),
            array(array('test' => '.27'),                 true),
            array(array('test' => .27),                   true),
            array(array('test' => '1e2'),                 true),
            array(array('test' => '+1353.0316547'),       true),
            array(array('test' => '13213.032468e-13465'), true),
            array(array('test' => '-8E+3'),               true),
            array(array('test' => '-1354.98879e+37436'),  true),

            array(array('test' => 15),                    false),
            array(array('test' => -15),                   false),
            array(array('test' => 0x1A),                  false),
            array(array('test' => 0123),                  false),
            array(array('test' => 0b11111111),            false),

            array(array('test' => "15"),                  false),
            array(array('test' => "-15"),                 false),
            array(array('test' => "0x1A"),                false),
            array(array('test' => "0123"),                false),
            array(array('test' => "0b11111111"),          false),

            array(array('test' => 'whatevs'),             false),
        );
    }

    /**
     * @covers \nkm\RedsysVirtualPos\Validation\Validator::float
     * @dataProvider floatInputProvider
     */
    public function testFloat($inputs, $expected)
    {
        $rules  = array(
            'test' => array('float')
        );

        $validation_result = \nkm\RedsysVirtualPos\Validation\Validator::validate($inputs, $rules);

        $this->assertEquals($expected, $validation_result->isSuccess());
    }
}
