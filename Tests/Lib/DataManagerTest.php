<?php

declare(strict_types = 1);

namespace Tests;

use PHPUnit\Framework\TestCase;

/**
 * @covers Email
 */
final class DataManagerTest extends TestCase {

    public function testclearData() {
        $sut = $this->getMockForAbstractClass('\Lib\DataManager', [], '', true, true, true, []);
        $class = new \ReflectionClass($sut);
        $reflection_property = $class->getProperty('data');
        $reflection_property->setAccessible(true);
        $reflection_property->setValue($sut, [0=>['a' => 'b']]);
        $this->assertTrue($sut->hasData());
        $sut->clearData();
        $this->assertFalse($sut->hasData());
    }

    
    // NOTE as this is a demonstration, the rest of this class is not thoroughly tested
}
