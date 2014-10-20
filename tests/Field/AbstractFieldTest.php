<?php

// public function __construct($value = null)
// public function getName()
// public function getRequestName()
// public function getResponseName()
// protected static function getAvailableValues()
// private static function hasAvailableValues()
// private static function hasAvailableValue($key)
// private static function getAvailableValue($key)
// public function setValue($value)
// public function getValue()

/**
 * @coversDefaultClass \nkm\RedsysVirtualPos\Field\AbstractField
 */
class ConcreteField extends \nkm\RedsysVirtualPos\Field\AbstractField
{
}

class AbstractFieldTest extends PHPUnit_Framework_TestCase
{
    private $className = '\nkm\RedsysVirtualPos\Field\AbstractField';

    /**
     * @covers ::__construct
     */
    public function testConstructorCallsInternalMethods()
    {
        $value = 'whatevs';

        // Get mock, without the constructor being called
        $mock = $this->getMockForAbstractClass(
            $this->className,
            [],
            '',
            false,
            true,
            true,
            ['setValue']
        );

        // set expectations for constructor calls
        $mock->expects($this->once())
        ->method('setValue')
        ->with($this->equalTo($value));

        // now call the constructor
        $rc = new ReflectionClass($this->className);
        $constructor = $rc->getConstructor();
        $constructor->invokeArgs($mock, [$value]);
    }

    /**
     * @covers ::getName
     */
    public function testGetNameDefault()
    {
        $concreteField = new ConcreteField();

        $this->assertSame('', $concreteField->getName());
    }

    /**
     * @covers ::getRequestName
     */
    public function testgetRequestNameDefault()
    {
        $concreteField = new ConcreteField();

        $this->assertSame('', $concreteField->getRequestName());
    }

    /**
     * @covers ::getResponseName
     */
    public function testgetResponseNameDefault()
    {
        $concreteField = new ConcreteField();

        $this->assertSame('', $concreteField->getResponseName());
    }

    public function getNameProvider()
    {
        return [
            ['',           ''],
            [0,            '0'],
            [0.0,          '0'],
            ['0',          '0'],
            [null,         ''],
            [[],           ''],
            [new stdClass, ''],
            ['whatevs',    'whatevs'],
        ];
    }

    /**
     * @covers          ::getName
     * @dataProvider    getNameProvider
     */
    public function testGetName($actual, $expected)
    {
        $concreteField = new ConcreteField();
        $rc = new ReflectionClass($concreteField);

        $rp = $rc->getProperty('name');
        $rp->setAccessible(true);
        $rp->setValue($concreteField, $actual);

        $rm = $rc->getMethod('getName');

        $this->assertEquals($expected, $rm->invoke($concreteField));
    }

    /**
     * @covers          ::getRequestName
     * @dataProvider    getNameProvider
     */
    public function testGetRequestName($actual, $expected)
    {
        $concreteField = new ConcreteField();
        $rc = new ReflectionClass($concreteField);

        $rp = $rc->getProperty('requestName');
        $rp->setAccessible(true);
        $rp->setValue($concreteField, $actual);

        $rm = $rc->getMethod('getRequestName');

        $this->assertEquals($expected, $rm->invoke($concreteField));
    }

    /**
     * @covers          ::getResponseName
     * @dataProvider    getNameProvider
     */
    public function testGetResponseName($actual, $expected)
    {
        $concreteField = new ConcreteField();
        $rc = new ReflectionClass($concreteField);

        $rp = $rc->getProperty('responseName');
        $rp->setAccessible(true);
        $rp->setValue($concreteField, $actual);

        $rm = $rc->getMethod('getResponseName');

        $this->assertEquals($expected, $rm->invoke($concreteField));
    }

    /**
     * @covers ::getAvailableValues
     */
    public function testGetAvailableValuesDefault()
    {
        $rm = new ReflectionMethod($this->className, 'getAvailableValues');
        $rm->setAccessible(true);

        $this->assertEquals([], $rm->invoke(null));
    }

    /**
     * @covers ::hasAvailableValues
     */
    public function testHasAvailableValuesDefault()
    {
        $rm = new ReflectionMethod($this->className, 'hasAvailableValues');
        $rm->setAccessible(true);

        $this->assertFalse($rm->invoke(null));
    }

    /**
     * @covers ::hasAvailableValue
     */
    public function testHasAvailableValueDefault()
    {
        $rm = new ReflectionMethod($this->className, 'hasAvailableValue');
        $rm->setAccessible(true);

        $this->assertFalse($rm->invokeArgs(null, ['whatevs']));
    }

    /**
     * @covers ::getAvailableValue
     */
    public function testGetAvailableValueDefault()
    {
        $rm = new ReflectionMethod($this->className, 'getAvailableValue');
        $rm->setAccessible(true);

        $this->assertNull($rm->invokeArgs(null, ['whatevs']));
    }

    public function availableValuesProvider()
    {
        return [
            [[], []],
            [null, []],
            [[1, 2, 3, 4], [1, 2, 3, 4]],
            [['a', 'b', 'c', 'd'], ['a', 'b', 'c', 'd']],
        ];
    }

    /**
     * @covers          ::getAvailableValues
     * @covers          ::hasAvailableValues
     * @dataProvider    availableValuesProvider
     */
    public function testHasAvailableValuesAndGetAvailableValues($actual, $expected)
    {
        $concreteField   = new ConcreteField();
        $concreteFieldRC = new ReflectionClass($concreteField);

        $availableValuesRP = $concreteFieldRC->getProperty('availableValues');
        $availableValuesRP->setAccessible(true);
        $availableValuesRP->setValue($concreteField, $actual);

        $getAvailableValuesRM = $concreteFieldRC->getMethod('getAvailableValues');
        $getAvailableValuesRM->setAccessible(true);

        $this->assertEquals($expected, $getAvailableValuesRM->invoke($concreteField));

        $hasAvailableValuesRM = $concreteFieldRC->getMethod('hasAvailableValues');
        $hasAvailableValuesRM->setAccessible(true);

        $this->assertEquals(!empty($expected), $hasAvailableValuesRM->invoke($concreteField));
    }

    public function availableValueProvider()
    {
        return [
            [['whatevs'], ['whatevs']],
            [[1, 2, 3], [1, 2, 3]],
            [['a' => '1', 'b' => '2', 'c' => '3'], ['a' => '1', 'b' => '2', 'c' => '3']],
        ];
    }

    /**
     * @covers          ::getAvailableValue
     * @covers          ::hasAvailableValue
     * @dataProvider    availableValueProvider
     */
    public function testHasAvailableValueAndGetAvailableValue($actual, $expected)
    {
        $concreteField   = new ConcreteField();
        $concreteFieldRC = new ReflectionClass($concreteField);

        $availableValuesRP = $concreteFieldRC->getProperty('availableValues');
        $availableValuesRP->setAccessible(true);
        $availableValuesRP->setValue($concreteField, $actual);

        $keys    = array_keys($expected);
        $lastKey = array_pop($keys);

        $hasAvailableValueRM = $concreteFieldRC->getMethod('hasAvailableValue');
        $hasAvailableValueRM->setAccessible(true);

        $this->assertTrue($hasAvailableValueRM->invokeArgs(null, [$lastKey]));

        $getAvailableValueRM = $concreteFieldRC->getMethod('getAvailableValue');
        $getAvailableValueRM->setAccessible(true);

        $this->assertEquals($expected[$lastKey], $getAvailableValueRM->invokeArgs(null, [$lastKey]));
    }

    /**
     * @covers ::setValue
     */
    public function testSetValue()
    {
        $this->markTestIncomplete('Not yet implemented');
    }

    /**
     * @covers ::getValue
     */
    public function testGetValue()
    {
        $this->markTestIncomplete('Not yet implemented');
    }
}
