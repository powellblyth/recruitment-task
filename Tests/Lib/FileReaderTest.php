<?php

declare(strict_types = 1);

namespace Tests;

use PHPUnit\Framework\TestCase;

/**
 * @covers Email
 */
final class FileReaderTest extends TestCase {

//@TODO make these work
//        public function testdestruct() {
//        $sut = $this->getMockForAbstractClass('\Lib\CSVImporter', ['moo'], '', true, true, true, ['clearFileHandle']);
//        $sut->expects($this->once())->method('clearFileHandle');
////$sut->expects($this->once())->method('getFile')->with(['moo']);
//    }
    
//    public function testConstruct() {
//        $sut = $this->getMockForAbstractClass('\Lib\FileReader', ['moo'], '', true, true, true, ['getFile']);
//        $sut->expects($this->once())->method('getFile');
////$sut->expects($this->once())->method('getFile')->with(['moo']);
//    }
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
        $sut = $this->getMockForAbstractClass('\Lib\FileReader', [$fileName], '', true, true, true, []);
        $class = new \ReflectionClass('\Lib\FileReader');
        $method = $class->getMethod('getFileHandle');
        $method->setAccessible(true);
        $handle = $method->invokeArgs($sut, [$fileName]);
        if ($expectHandle) {
            $this->assertTrue(is_resource($handle));
        } else {
            $this->assertFalse(is_resource($handle));
        }
        if (is_resource($handle))
        {
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
        $sut = $this->getMockForAbstractClass('\Lib\FileReader', [$filePath], '', true, true, true, ['getFileHandle', 'fileIsReal', 'clearFileHandle', '__destruct']);
        $sut->method('fileIsReal')->willReturn($isFileReal);
        $sut->expects($this->exactly($timesCalledGetFileHandle))->method('getFileHandle')->with($filePath);
        $sut->expects($this->exactly(1))->method('clearFileHandle');
        $sut->expects($this->exactly(1))->method('fileIsReal')->with($filePath);
        $sut->getFile($filePath);
    }

}
