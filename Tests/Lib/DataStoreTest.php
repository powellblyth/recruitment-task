<?php

declare(strict_types = 1);

namespace Tests;

use PHPUnit\Framework\TestCase;

/**
 * @covers Email
 */
final class DataStoreTest extends TestCase {

    public function testclearData() {
        $testData = [0=>['a' => 'b']];
        
        $sut = $this->getMockForAbstractClass('\Lib\DataStore', [], '', true, true, true, []);
        $class = new \ReflectionClass($sut);
        $reflection_property = $class->getProperty('data');
        $reflection_property->setAccessible(true);
        $sut->setData($testData);
        $reflection_property->setValue($sut, $testData);
        $this->assertTrue($sut->hasData());
        $this->assertSame($testData, $reflection_property->getValue($sut));
        $sut->clearData();
        $this->assertFalse($sut->hasData());
    }
    
            

    
    // NOTE as this is a demonstration, the rest of this class is not thoroughly tested
}
