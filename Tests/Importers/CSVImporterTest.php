<?php

declare(strict_types = 1);

namespace Tests;

use PHPUnit\Framework\TestCase;

/**
 * @covers Email
 */
final class CSVImporterTest extends TestCase {

    public function providerloadData() {
        return [
            [1, true, 1, [], false],
            [1, false, 0, ['a'=>'b'], false],
            [1, true, 1, null, true],
        ];
    }

    /**
     * @dataProvider providerloadData
     * @param type $expectHandleIsValidCount
     * @param type $handleIsValidResult
     * @param type $expectgetCSVCount
     * @param type $getCSVResult
     */
    public function testloadData($expectHandleIsValidCount, $handleIsValidResult, $expectgetCSVCount, $getCSVResult, $expectException) {
        $sut = $this->getMockBuilder('\\Importers\\CSVImporter')
                ->setMethods(array('fileHandleIsValid', 'getCSV'))
                ->disableOriginalClone()
                ->setConstructorArgs(array(__FILE__))
                ->disableArgumentCloning()
                ->disallowMockingUnknownTypes()
                ->getMock();

        $sut->method('fileHandleIsValid')->willReturn($handleIsValidResult);

        $sut->method('getCSV')->willReturn($getCSVResult);

        $sut->expects($this->exactly($expectHandleIsValidCount))->method('fileHandleIsValid');
        $sut->expects($this->exactly($expectgetCSVCount))->method('getCSV')->with($this->anything(), ",", "\"", "\\");


        if ($expectException) {
            $this->expectException(\Exceptions\ImporterException::class);
        }
        $sut->loadData();



        unset($sut);
    }

    public function providerConstructor() {
        return [
            ['bar', 'far', 'lar', 'tar']
        ];
    }

    /**
     * @dataProvider providerConstructor
     * 
     */
    public function testConstructor(string $filePath, string $delimiter, string $enclosure, string $escape) {
        $sut = $this->getMockBuilder('Importers\\CSVImporter')
                ->setMethods(array('fileHandleIsValid', 'getCSV'))
                ->disableOriginalClone()
                ->setConstructorArgs(array($filePath, $delimiter, $enclosure, $escape))
                ->disableArgumentCloning()
                ->disallowMockingUnknownTypes()
                ->getMock();

        $sut->method('fileHandleIsValid')->willReturn(true);
        $sut->method('getCSV')->willReturn([]);

        $sut->expects($this->exactly(1))->method('fileHandleIsValid');
        $sut->expects($this->exactly(1))->method('getCSV')->with($this->anything(), $this->equalTo($delimiter), $this->equalTo($enclosure), $this->equalTo($escape));
        $sut->loadData();
    }

    public function providergetFileHandle() {
        return [
            [__FILE__, true],
            ['/path/to/nowhere', false]
        ];
    }

    /**
     * @dataProvider providergetFileHandle
     */
    public function testgetFileHandle($fileName, $expectHandle) {
        $sut = $this->getMockBuilder('Importers\\CSVImporter')
                ->setMethods(array())
                ->disableOriginalClone()
                ->setConstructorArgs(array($fileName))
                ->disableArgumentCloning()
                ->disallowMockingUnknownTypes()
                ->getMock();
        $class = new \ReflectionClass($sut);
        $method = $class->getMethod('getFileHandle');
        $method->setAccessible(true);
        $handle = $method->invokeArgs($sut, [$fileName]);
        if ($expectHandle) {
            $this->assertTrue(is_resource($handle));
        } else {
            $this->assertFalse(is_resource($handle));
        }
        if (is_resource($handle)) {
            fclose($handle);
        }
    }

    protected function getFileHandle(string $filePath) {
        return fopen($filePath, 'r');
    }

    public function providerGetFile() {
        return [
            ['/foo/bar', 0, false],
            ['../foo/bar', 0, false],
            ['bob.xml', 0, false],
            ['bob.xml', 1, true]
        ];
    }

    /**
     * @dataProvider providergetFile
     */
    public function testGetFile($filePath, $timesCalledGetFileHandle, $isFileReal) {
        $sut = $this->getMockBuilder('\\Importers\\CSVImporter')
                ->setMethods(array('getFileHandle', 'fileIsReal', 'clearFileHandle', '__destruct'))
                ->disableOriginalClone()
                ->setConstructorArgs(array(__FILE__))
                ->disableArgumentCloning()
                ->disallowMockingUnknownTypes()
                ->getMock();

        $sut->method('fileIsReal')->willReturn($isFileReal);
        $sut->expects($this->exactly($timesCalledGetFileHandle))->method('getFileHandle')->with($filePath);
        $sut->expects($this->exactly(1))->method('clearFileHandle');
        $sut->expects($this->exactly(1))->method('fileIsReal')->with($filePath);
        $sut->getFile($filePath);
    }

}
