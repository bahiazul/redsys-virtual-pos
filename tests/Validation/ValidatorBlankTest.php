<?php

use \PHPUnit\Framework\TestCase;
use \Bahiazul\RedsysVirtualPos\Validation\Validator;

class ValidatorBlankTest extends TestCase
{
    public function blankInputProvider()
    {
        return array(
            array(null,                     true),
            array(array(),                  true),
            array(array('test' => null),    true),
            array(array('test' => 'null'),  false),

            array(array('test' => ''),      true),
            array(array('test' => ' '),     true),
            array(array('test' => "\t"),    true),
            array(array('test' => "\n"),    true),
            array(array('test' => "\r"),    true),
            array(array('test' => ' '),     false), // non-breaking space

            array(array('test' => 0),       false),
            array(array('test' => 0.0),     false),
            array(array('test' => .0),      false),
            array(array('test' => 0.),      false),
            array(array('test' => '0'),     false),
            array(array('test' => '0.0'),   false),
            array(array('test' => '.0'),    false),
            array(array('test' => '0.'),    false),

            array(array('test' => true),    false),
            array(array('test' => false),   false),
            array(array('test' => 'true'),  false),
            array(array('test' => 'false'), false),

            array(array('test' => []),      false),
            array(array('test' => '[]'),    false),
            array(array('test' => '{}'),    false),
        );
    }

    /**
     * @covers \Bahiazul\RedsysVirtualPos\Validation\Validator::blank
     * @dataProvider blankInputProvider
     */
    public function testBlank($inputs, $expected)
    {
        $rules  = array(
            'test' => array('blank')
        );

        $validation_result = Validator::validate($inputs, $rules);

        $this->assertEquals($expected, $validation_result->isSuccess());
    }
}
