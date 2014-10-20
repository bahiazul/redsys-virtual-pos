<?php

/**
 * @coversDefaultClass \nkm\RedsysVirtualPos\Environment\AbstractEnvironment
 */
class AbstractEnvironmentTest extends PHPUnit_Framework_TestCase
{
    private $environment;

    public function setUp()
    {
        $this->environment = $this->getMockForAbstractClass(
            '\nkm\RedsysVirtualPos\Environment\AbstractEnvironment',
            [],
            '',
            false,
            true,
            true
        );
    }

    public function getEmptyProvider()
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
     * @covers ::getSecret
     */
    public function testGetSecretDefault()
    {
        $this->setExpectedException(
            '\nkm\RedsysVirtualPos\Environment\EnvironmentException',
            'Merchant secret is not set.'
        );

        $this->environment->getSecret();
    }

    /**
     * @covers          ::getSecret
     * @dataProvider    getEmptyProvider
     */
    public function testGetSecretEmpty($newSecret)
    {
        $this->setExpectedException(
            '\nkm\RedsysVirtualPos\Environment\EnvironmentException',
            'Merchant secret is not set.'
        );

        $this->environment->setSecret($newSecret);

        $this->environment->getSecret();
    }

    public function setSecretProvider()
    {
        return [
            ['This cosmic dance﻿ of bursting decadence and withheld permissions'],
            ['twists all our arms collectively, but if sweetness can win, and it can,'],
            ['then I\'ll still be here tomorrow, to high five you yesterday my friend.'],
            ['Peace'],
        ];
    }

    /**
     * @covers          ::setSecret
     * @dataProvider    setSecretProvider
     */
    public function testSetSecret($newSecret)
    {
        $this->environment->setSecret($newSecret);

        $this->assertEquals($newSecret, $this->environment->getSecret());
    }

    /**
     * @covers ::getEndpoint
     */
    public function testGetEndpoint()
    {
        $this->setExpectedException(
            '\nkm\RedsysVirtualPos\Environment\EnvironmentException',
            'Environment\'s Base Endpoint is not set.'
        );

        $this->environment->getEndpoint('whatevs');
    }
}
