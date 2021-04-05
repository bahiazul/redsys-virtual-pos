<?php

use \PHPUnit\Framework\TestCase;
use \Bahiazul\RedsysVirtualPos\Validation\Validator;

class CustomValidator extends Validator
{
    public static function trueRule($input)
    {
        return true;
    }

    public static function falseRule($input)
    {
        return false;
    }

    public static function testParamRule($input, $param)
    {
        return true;
    }

    public static function multipleParams($input, $param1, $param2, $param3)
    {
        if (($param1 == 1) && ($param2 == 2) && ($param3 == 3)) {
            return true;
        }

        return false;
    }
}

class ValidatorExtendedClassTest extends TestCase
{
    public function extendedClassInputProvider()
    {
        return array(
            array(array('test' => 'dummy input'), array('test' => array('trueRule')),                  true),
            array(array('test' => 'dummy input'), array('test' => array('falseRule')),                 false),
            array(array('test' => 'dummy input'), array('test' => array('testParamRule(test)')),       true),
            array(array('test' => 'dummy input'), array('test' => array('multipleParams(1,2,3)')),     true),
            array(array('test' => 'dummy input'), array('test' => array('multipleParams(3,2,1)')),     false),
        );
    }

    /**
     * @dataProvider extendedClassInputProvider
     */
    public function testExtendedClass($inputs, $rules, $expected)
    {
        $validation_result = CustomValidator::validate($inputs, $rules);

        $this->assertEquals($expected, $validation_result->isSuccess());
    }
}
