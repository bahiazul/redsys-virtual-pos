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

/**
 * @coversDefaultClass \nkm\RedsysVirtualPos\Field\AbstractField
 */
class ConcreteRequestField extends \nkm\RedsysVirtualPos\Field\AbstractField
{
    protected $inRequest = true;
}

/**
 * @coversDefaultClass \nkm\RedsysVirtualPos\Field\AbstractField
 */
class ConcreteResponseField extends \nkm\RedsysVirtualPos\Field\AbstractField
{
    protected $inResponse = true;
}

class AbstractFieldTest extends PHPUnit_Framework_TestCase
{
    private $className = '\nkm\RedsysVirtualPos\Field\AbstractField';

    private $field;

    public function setUp()
    {
        $this->field = $this->getMockForAbstractClass(
            $this->className,
            [],
            '',
            false,
            true,
            true
        );
    }

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

        $this->assertSame('ConcreteField', $concreteField->getName());
    }

    /**
     * @covers ::getRequestName
     */
    public function testgetRequestNameDefault()
    {
        $concreteField = new ConcreteRequestField();

        $this->assertSame('Ds_Merchant_ConcreteRequestField', $concreteField->getRequestName());
    }

    /**
     * @covers ::getResponseName
     */
    public function testgetResponseNameDefault()
    {
        $concreteField = new ConcreteResponseField();

        $this->assertSame('Ds_ConcreteResponseField', $concreteField->getResponseName());
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

    public function setValueProvider()
    {
        return [
            ['', ''],
            ['whatevs', 'whatevs'],
            [0, '0'],
            [0.0, '0.0'],
            [null, ''],
            [false, ''],
            [[], ''],
            [[1,2,3], ''],
            [new stdClass, ''],
            [new SimpleXMLElement('<yo>dude!</yo>'), 'dude!'],
        ];
    }

    /**
     * @covers          ::setValue
     * @dataProvider    setValueProvider
     */
    public function testSetValue($actual, $expected)
    {
        $concreteField   = new ConcreteField();
        $concreteField->setValue($actual);

        $concreteFieldRC = new ReflectionClass($concreteField);

        $valueRP = $concreteFieldRC->getProperty('value');
        $valueRP->setAccessible(true);

        $this->assertEquals($expected, $valueRP->getValue($concreteField));
    }

    public function getValueProvider()
    {
        return [
            [''],
            [0],
            [0.0],
            ['0'],
            [null],
            [[]],
            [new stdClass],
        ];
    }

    /**
     * @covers          ::getValue
     * @dataProvider    getValueProvider
     */
    public function testGetValue($actual)
    {
        $concreteField   = new ConcreteField();
        $concreteFieldRC = new ReflectionClass($concreteField);

        $valueRP = $concreteFieldRC->getProperty('value');
        $valueRP->setAccessible(true);
        $valueRP->setValue($concreteField, $actual);

        $getValueRM = $concreteFieldRC->getMethod('getValue');
        $getValueRM->setAccessible(true);

        $this->assertEquals($actual, $getValueRM->invokeArgs($concreteField, []));
    }
}
