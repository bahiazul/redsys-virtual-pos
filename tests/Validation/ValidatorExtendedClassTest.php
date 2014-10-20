<?php

class CustomValidator extends \nkm\RedsysVirtualPos\Validation\Validator
{
    public static function trueStaticRule($input)
    {
        return true;
    }

    public static function falseStaticRule($input)
    {
        return false;
    }

    public function trueRule($input)
    {
        return true;
    }

    public static function testParamStaticRule($input, $param)
    {
        return true;
    }

    public function testParamRule($input, $param)
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

class ValidatorExtendedClassTest extends PHPUnit_Framework_TestCase
{
    public function extendedClassInputProvider()
    {
        return array(
            array(array('test' => 'dummy input'), array('test' => array('trueStaticRule')),            true),
            array(array('test' => 'dummy input'), array('test' => array('falseStaticRule')),           false),
            array(array('test' => 'dummy input'), array('test' => array('testParamStaticRule(test)')), true),
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

    public function nonStaticMethodInputProvider()
    {
        return array(
            array(null, array('test' => array('trueRule'))),
            array(null, array('test' => array('testParamRule(test)'))),
        );
    }

    /**
     * @dataProvider nonStaticMethodInputProvider
     * @expectedException \nkm\RedsysVirtualPos\Validation\ValidatorException
     * @expectedExceptionCode \nkm\RedsysVirtualPos\Validation\ValidatorException::STATIC_METHOD
     */
    public function testNonStaticMethods($inputs, $rules)
    {
        $validation_result = CustomValidator::validate($inputs, $rules);

        $this->assertEquals($expected, $validation_result->isSuccess());
    }
}
