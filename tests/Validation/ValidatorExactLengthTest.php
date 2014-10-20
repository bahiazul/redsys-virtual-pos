<?php

class ValidatorExactLengthTest extends PHPUnit_Framework_TestCase
{
    public function exactLengthInputProvider()
    {
        return array(
            array(array('test' => null),          array('test' => array('exact_length(5)')),  true),
            array(array('test' => ''),            array('test' => array('exact_length(5)')),  true),

            array(array('test' => 'ABCDE'),       array('test' => array('exact_length(5)')),  true),
            array(array('test' => 'ABCDE'),       array('test' => array('exact_length(10)')), false),

            array(array('test' => 'ABCDE123'),    array('test' => array('exact_length(8)')),  true),
            array(array('test' => 'ABCDE123'),    array('test' => array('exact_length(5)')),  false),

            array(array('test' => 'ABCDE123?!@'), array('test' => array('exact_length(11)')), true),
            array(array('test' => 'ABCDE123?!@'), array('test' => array('exact_length(5)')),  false),

            array(array('test' => '   ABCDE   '), array('test' => array('exact_length(5)')),  false),
            array(array('test' => '   ABCDE   '), array('test' => array('exact_length(11)')), true),
        );
    }

    /**
     * @covers \nkm\RedsysVirtualPos\Validation\Validator::exact_length
     * @dataProvider exactLengthInputProvider
     */
    public function testExactLength($inputs, $rules, $expected)
    {
        $validation_result = \nkm\RedsysVirtualPos\Validation\Validator::validate($inputs, $rules);

        $this->assertEquals($expected, $validation_result->isSuccess());
    }
}
