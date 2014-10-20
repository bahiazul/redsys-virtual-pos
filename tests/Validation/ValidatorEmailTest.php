<?php

class ValidatorEmailTest extends PHPUnit_Framework_TestCase
{
    public function emailInputProvider()
    {
        return array(
            array(array('test' => null),                 true),
            array(array('test' => ''),                   true),
            array(array('test' => 'geliscan@gmail.com'), true),
            array(array('test' => 'SimpleValidator'),    false),
        );
    }

    /**
     * @covers \nkm\RedsysVirtualPos\Validation\Validator::email
     * @dataProvider emailInputProvider
     */
    public function testEmail($inputs, $expected)
    {
        $rules  = array(
            'test' => array('email')
        );

        $validation_result = \nkm\RedsysVirtualPos\Validation\Validator::validate($inputs, $rules);

        $this->assertEquals($expected, $validation_result->isSuccess());
    }
}
