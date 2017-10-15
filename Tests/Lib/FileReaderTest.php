<?php

declare(strict_types = 1);

namespace Tests;

use PHPUnit\Framework\TestCase;

/**
 * @covers Email
 */
final class FileReaderTest extends TestCase {

    public function providerfileIsReal() {
        return [
            [__FILE__, true],
            ['/path/to/nowhere', false]
        ];
    }

    /**
     * @dataProvider providerfileIsReal
     */
    public function testfileIsReal($fileName, $expectIsValid) {
        $sut = $this->getMockForAbstractClass('\Lib\FileReader', [$fileName], '', true, true, true, []);
        $class = new \ReflectionClass($sut);
        $method = $class->getMethod('fileIsReal');
        $method->setAccessible(true);
        $this->assertEquals($expectIsValid, $method->invokeArgs($sut, [$fileName]));
    }


}
