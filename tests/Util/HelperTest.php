<?php

/**
 * @coversDefaultClass \nkm\RedsysVirtualPos\Util\Helper
 */
class HelperTest extends PHPUnit_Framework_TestCase
{
    private $className = '\nkm\RedsysVirtualPos\Util\Helper';

    public function stringifyProvider()
    {
        return [
            ['',                                     ''],
            ['whatevs',                              'whatevs'],
            [0,                                      '0'],
            [0.0,                                    '0.0'],
            [null,                                   ''],
            [false,                                  ''],
            [[],                                     ''],
            [[1,2,3],                                ''],
            [new stdClass,                           ''],
            [new SimpleXMLElement('<yo>dude!</yo>'), 'dude!'],
        ];
    }

    /**
     * @covers          ::stringify
     * @dataProvider    stringifyProvider
     */
    public function testStringify($actual, $expected)
    {
        $rm = new ReflectionMethod($this->className, 'stringify');
        $rm->setAccessible(true);

        $this->assertEquals($expected, $rm->invokeArgs(null, [$actual]));
    }
}
