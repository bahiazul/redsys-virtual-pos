<?php

use \PHPUnit\Framework\TestCase;
use \nkm\RedsysVirtualPos\Validation\Validator;

class ValidatorEqualsTest extends TestCase
{
    public function equalInputProvider()
    {
        return array(
            array(array('test1' => 'foo', 'test2' => 'foo'),  true),
            array(array('test1' => 'foo', 'test2' => 'foo2'), false),
            array(array('test1' => 'foo', 'test2' => null),   false),
            array(array('test1' => 'foo', 'test2' => ''),     false),
            array(array('test1' => 'foo'),                    false),
        );
    }

    /**
     * @covers \nkm\RedsysVirtualPos\Validation\Validator::equals
     * @dataProvider equalInputProvider
     */
    public function testEquals($inputs, $expected)
    {
        $rules = array(
            'test1' => array('equals(:test2)')
        );

        $validation_result = Validator::validate($inputs, $rules);

        $this->assertEquals($expected, $validation_result->isSuccess());
    }
}
