<?php

declare(strict_types = 1);

namespace Tests\Outputters;

use PHPUnit\Framework\TestCase;

/**
 * @covers Email
 */
final class BaseTest extends TestCase {

    public function testsetDataPoint() {
        $input = rand(0, 1000);
        $sut = $this->getMockForAbstractClass('\Outputters\Base', [], '', true, true, true, []);
        $class = new \ReflectionClass($sut);
        $reflection_property = $class->getProperty('dataPoint');
        $reflection_property->setAccessible(true);

        $this->assertNotSame($input, $reflection_property->getValue($sut));
        $sut->setDataPoint($input);
        $this->assertSame($input, $reflection_property->getValue($sut));
    }

}
