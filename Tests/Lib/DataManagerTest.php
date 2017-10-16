<?php

declare(strict_types = 1);

namespace Tests;

use PHPUnit\Framework\TestCase;

/**
 * @covers Email
 */
final class DataManagerTest extends TestCase {

    public function testconstruct() {
        $testData = [0 => ['a' => 5]];

        $mockDataStore = $this->createMock('\Lib\DataStore');

        $sut = $this->getMockForAbstractClass('\Lib\DataManager', [$mockDataStore], '', true, true, true, []);
        $class = new \ReflectionClass($sut);
        $reflection_property = $class->getProperty('dataStore');
        $reflection_property->setAccessible(true);
        $this->assertSame($mockDataStore, $reflection_property->getValue($sut));
    }

    public function testtotaliseColumn() {
        $testData = [0 => ['a' => 5]];

        $mockDataStore = new \Lib\DataStore();
        $mockDataStore->setData($testData);

        $sut = $this->getMockForAbstractClass('\Lib\DataManager', [$mockDataStore], '', true, true, true, []);
        $this->assertSame(5, $sut->totaliseColumn('a'));
    }

    public function testaverageColumn() {
        $testData = [0 => ['a' => 5], 1 => ['a' => 3]];

        $mockDataStore = new \Lib\DataStore();
        $mockDataStore->setData($testData);

        $sut = $this->getMockForAbstractClass('\Lib\DataManager', [$mockDataStore], '', true, true, true, []);
        $this->assertSame(4, $sut->averageColumn('a'));
    }

    // NOTE as this is a demonstration, the rest of this class is not thoroughly tested
}
