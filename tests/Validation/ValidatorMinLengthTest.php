<?php

class ValidatorMinLengthTest extends PHPUnit_Framework_TestCase
{
    public function minLengthInputProvider()
    {
        return array(
            array(array('test' => null),          array('test' => array('min_length(5)')),  true),
            array(array('test' => ''),            array('test' => array('min_length(5)')),  true),

            array(array('test' => 'ABCDE'),       array('test' => array('min_length(5)')),  true),
            array(array('test' => 'ABCDE'),       array('test' => array('min_length(10)')), false),
            array(array('test' => 'ABCDE'),       array('test' => array('min_length(3)')),  true),

            array(array('test' => 'ABCDE123'),    array('test' => array('min_length(8)')),  true),
            array(array('test' => 'ABCDE123'),    array('test' => array('min_length(12)')), false),
            array(array('test' => 'ABCDE123'),    array('test' => array('min_length(5)')),  true),

            array(array('test' => 'ABCDE123?!@'), array('test' => array('min_length(11)')), true),
            array(array('test' => 'ABCDE123?!@'), array('test' => array('min_length(15)')), false),
            array(array('test' => 'ABCDE123?!@'), array('test' => array('min_length(5)')),  true),

            array(array('test' => '   ABCDE   '), array('test' => array('min_length(11)')), true),
            array(array('test' => '   ABCDE   '), array('test' => array('min_length(15)')), false),
            array(array('test' => '   ABCDE   '), array('test' => array('min_length(5)')),  true),
        );
    }

    /**
     * @covers \nkm\RedsysVirtualPos\Validation\Validator::min_length
     * @dataProvider minLengthInputProvider
     */
    public function testMinLength($inputs, $rules, $expected)
    {
        $validation_result = \nkm\RedsysVirtualPos\Validation\Validator::validate($inputs, $rules);

        $this->assertEquals($expected, $validation_result->isSuccess());
    }
}
