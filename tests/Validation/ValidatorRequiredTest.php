<?php

use \PHPUnit\Framework\TestCase;
use \nkm\RedsysVirtualPos\Validation\Validator;

class ValidatorRequiredTest extends TestCase
{
    public function requiredInputProvider()
    {
        return array(
            array(null,                     false),
            array(array(),                  false),
            array(array('test' => null),    false),
            array(array('test' => 'null'),  true),

            array(array('test' => ''),      false),
            array(array('test' => ' '),     false),
            array(array('test' => "\t"),    false),
            array(array('test' => "\n"),    false),
            array(array('test' => "\r"),    false),
            array(array('test' => ' '),     true), // non-breaking space

            array(array('test' => 0),       true),
            array(array('test' => 0.0),     true),
            array(array('test' => .0),      true),
            array(array('test' => 0.),      true),
            array(array('test' => '0'),     true),
            array(array('test' => '0.0'),   true),
            array(array('test' => '.0'),    true),
            array(array('test' => '0.'),    true),

            array(array('test' => true),    true),
            array(array('test' => false),   true),
            array(array('test' => 'true'),  true),
            array(array('test' => 'false'), true),

            array(array('test' => []),      true),
            array(array('test' => '[]'),    true),
            array(array('test' => '{}'),    true),
        );
    }

    /**
     * @covers \nkm\RedsysVirtualPos\Validation\Validator::required
     * @dataProvider requiredInputProvider
     */
    public function testRequired($inputs, $expected)
    {
        $rules  = array(
            'test' => array('required')
        );

        $validation_result = Validator::validate($inputs, $rules);

        $this->assertEquals($expected, $validation_result->isSuccess());
    }
}
