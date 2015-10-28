<?php

/**
 * @coversDefaultClass \nkm\RedsysVirtualPos\Util\Helper
 */
class HelperTest extends PHPUnit_Framework_TestCase
{
    private $className = '\nkm\RedsysVirtualPos\Util\Helper';
    private $key = 'lo4lcsVm14uTTpVyer5Y8rjg';

    public function base64url_encodeProvider()
    {
        return [
            ["Where are my testicles, Summer?", "V2hlcmUgYXJlIG15IHRlc3RpY2xlcywgU3VtbWVyPw=="],
            ["Alien Invasion Tomato Monster Mexican Armada Brothers Who Are Just Regular Brothers Running In A Van From An Asteroid And All Sorts Of Things: The Movie", "QWxpZW4gSW52YXNpb24gVG9tYXRvIE1vbnN0ZXIgTWV4aWNhbiBBcm1hZGEgQnJvdGhlcnMgV2hvIEFyZSBKdXN0IFJlZ3VsYXIgQnJvdGhlcnMgUnVubmluZyBJbiBBIFZhbiBGcm9tIEFuIEFzdGVyb2lkIEFuZCBBbGwgU29ydHMgT2YgVGhpbmdzOiBUaGUgTW92aWU="],
            ["My man!", "TXkgbWFuIQ=="],
            ["Nobody exists on purpose. Nobody belongs anywhere. Everybody’s gonna die. Come watch TV?", "Tm9ib2R5IGV4aXN0cyBvbiBwdXJwb3NlLiBOb2JvZHkgYmVsb25ncyBhbnl3aGVyZS4gRXZlcnlib2R54oCZcyBnb25uYSBkaWUuIENvbWUgd2F0Y2ggVFY_"],
            ["HI! I'M MR MEESEEKS! LOOK AT ME!", "SEkhIEknTSBNUiBNRUVTRUVLUyEgTE9PSyBBVCBNRSE="],
            ["Wubbalubbadubdub!", "V3ViYmFsdWJiYWR1YmR1YiE="],
            ["I hate Mumunmunundsdays.", "SSBoYXRlIE11bXVubXVudW5kc2RheXMu"],
        ];
    }

    public function base64url_decodeProvider()
    {
        return [
            ["V2hlcmUgYXJlIG15IHRlc3RpY2xlcywgU3VtbWVyPw==", "Where are my testicles, Summer?"],
            ["QWxpZW4gSW52YXNpb24gVG9tYXRvIE1vbnN0ZXIgTWV4aWNhbiBBcm1hZGEgQnJvdGhlcnMgV2hvIEFyZSBKdXN0IFJlZ3VsYXIgQnJvdGhlcnMgUnVubmluZyBJbiBBIFZhbiBGcm9tIEFuIEFzdGVyb2lkIEFuZCBBbGwgU29ydHMgT2YgVGhpbmdzOiBUaGUgTW92aWU=", "Alien Invasion Tomato Monster Mexican Armada Brothers Who Are Just Regular Brothers Running In A Van From An Asteroid And All Sorts Of Things: The Movie"],
            ["TXkgbWFuIQ==", "My man!"],
            ["Tm9ib2R5IGV4aXN0cyBvbiBwdXJwb3NlLiBOb2JvZHkgYmVsb25ncyBhbnl3aGVyZS4gRXZlcnlib2R54oCZcyBnb25uYSBkaWUuIENvbWUgd2F0Y2ggVFY_", "Nobody exists on purpose. Nobody belongs anywhere. Everybody’s gonna die. Come watch TV?"],
            ["SEkhIEknTSBNUiBNRUVTRUVLUyEgTE9PSyBBVCBNRSE=", "HI! I'M MR MEESEEKS! LOOK AT ME!"],
            ["V3ViYmFsdWJiYWR1YmR1YiE=", "Wubbalubbadubdub!"],
            ["SSBoYXRlIE11bXVubXVudW5kc2RheXMu", "I hate Mumunmunundsdays."],
        ];
    }

    public function hash_hmac_sha256Provider()
    {
        return [
            ["Where are my testicles, Summer?", "602cd0a5b7d7c857fc6ac18f051d8098a53adba114e90feb14aeb74fafde344d"],
            ["Alien Invasion Tomato Monster Mexican Armada Brothers Who Are Just Regular Brothers Running In A Van From An Asteroid And All Sorts Of Things: The Movie", "fc51727cc4e1feab432b0017cd396c83fd4bb7598afc8d23c04908f7ff41da03"],
            ["My man!", "77cae6cc690319400a5eecb8edd969ebee32614345f74ea0e5337c1528bf23ff"],
            ["Nobody exists on purpose. Nobody belongs anywhere. Everybody’s gonna die. Come watch TV?", "7cba0f52548531be703da2fdea7927cb9c684b2fb233a8c5f354ef07646b8272"],
            ["HI! I'M MR MEESEEKS! LOOK AT ME!", "e5af783c6c63f5d13215c27e6513f6a328291975abb42818cdac913d5eff49ab"],
            ["Wubbalubbadubdub!", "7dc8807a0c8576d694580275872b931a7032c4032431fb78acf392e02f5c7e23"],
            ["I hate Mumunmunundsdays.", "d0018ecd729a14fbc4746253e6a93ed523dec22c5a5e407715b25a3c8a6f32f9"],
        ];
    }

    public function mcrypt_encrypt_3DESProvider()
    {
        return [
            ["Where are my testicles, Summer?", "c6c972dba6e9fdbe31108187a80429d8ac99686ac41d47244b375aac12fe5d57"],
            ["Alien Invasion Tomato Monster Mexican Armada Brothers Who Are Just Regular Brothers Running In A Van From An Asteroid And All Sorts Of Things: The Movie", "90a12ee81cce4711e5d11972533180b0625361d09c45fa000f699004941ba2540118edc240770ce73fc72dc28087b253af46cdb155c70981803e9421751e2b3bb5b9bcef9502fdb4a0f7b30b31f9d758a837146ca4b044e4de2eccbbbae68c5d27dbcc6bb92d7dffdc9fa9acaded7079669506029c87046757c831226dfd9bc4b1dc5d54e072151497be4135cb969a620945a0452b9aea80"],
            ["My man!", "5ee3527f3626ce73"],
            ["Nobody exists on purpose. Nobody belongs anywhere. Everybody’s gonna die. Come watch TV?", "fb6180a3a5cbdd408da7f270556fce19ceca23a045fafce2e3d4d84084a9d84472f887c8422dbe581ce965ede6f17b1493b092629b124c88020276d11a6bc1a900192e303049657d1d939dac553e5e3c5429e0f1c858067f4fe1becdcd4beedc"],
            ["HI! I'M MR MEESEEKS! LOOK AT ME!", "3770e25038ba4dfc7cb230fa7895a8b14c9681feb7b4b730d2db3d96290e5772"],
            ["Wubbalubbadubdub!", "ca431d149eef7a2efb64f78ccdffa8266da374cc3769ea6d"],
            ["I hate Mumunmunundsdays.", "400be88b73e61be67a6b4d94ccac6c7f7755400c0c518ccb"],
        ];
    }

    public function stringifyProvider()
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
     * @covers          ::base64url_encode
     * @dataProvider    base64url_encodeProvider
     */
    public function testBase64url_encode($actual, $expected)
    {
        $rm = new ReflectionMethod($this->className, 'base64url_encode');
        $rm->setAccessible(true);

        $this->assertEquals($expected, $rm->invokeArgs(null, [$actual]));
    }

    /**
     * @covers          ::base64url_decode
     * @dataProvider    base64url_decodeProvider
     */
    public function testBase64url_decode($actual, $expected)
    {
        $rm = new ReflectionMethod($this->className, 'base64url_decode');
        $rm->setAccessible(true);

        $this->assertEquals($expected, $rm->invokeArgs(null, [$actual]));
    }

    /**
     * @covers          ::hash_hmac_sha256
     * @dataProvider    hash_hmac_sha256Provider
     */
    public function testHash_hmac_sha256($actual, $expected)
    {
        $rm = new ReflectionMethod($this->className, 'hash_hmac_sha256');
        $rm->setAccessible(true);

        $this->assertEquals($expected, bin2hex($rm->invokeArgs(null, [$actual, $this->key])));
    }

    /**
     * @covers          ::mcrypt_encrypt_3DES
     * @dataProvider    mcrypt_encrypt_3DESProvider
     */
    public function testMcrypt_encrypt_3DES($actual, $expected)
    {
        $rm = new ReflectionMethod($this->className, 'mcrypt_encrypt_3DES');
        $rm->setAccessible(true);

        $this->assertEquals($expected, bin2hex($rm->invokeArgs(null, [$actual, $this->key])));
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
