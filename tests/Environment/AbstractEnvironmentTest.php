<?php

use \PHPUnit\Framework\TestCase;

use \Bahiazul\RedsysVirtualPos\Environment\AbstractEnvironment;
use \Bahiazul\RedsysVirtualPos\Environment\EnvironmentException;

/**
 * @coversDefaultClass \Bahiazul\RedsysVirtualPos\Environment\AbstractEnvironment
 */
class AbstractEnvironmentTest extends TestCase
{
    private $environment;

    public function setUp(): void
    {
        $this->environment = $this->getMockForAbstractClass(
            AbstractEnvironment::class,
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
        $this->expectException(EnvironmentException::class);
        $this->expectExceptionMessage('Merchant secret is not set.');

        $this->environment->getSecret();
    }

    /**
     * @covers          ::getSecret
     * @dataProvider    getEmptyProvider
     */
    public function testGetSecretEmpty($newSecret)
    {
        $this->expectException(EnvironmentException::class);
        $this->expectExceptionMessage('Merchant secret is not set.');

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
        $this->expectException(EnvironmentException::class);
        $this->expectExceptionMessage('Environment\'s Base Endpoint is not set.');

        $this->environment->getEndpoint('whatevs');
    }
}
