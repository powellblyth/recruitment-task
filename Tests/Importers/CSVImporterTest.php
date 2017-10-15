<?php

declare(strict_types = 1);

namespace Tests;

use PHPUnit\Framework\TestCase;

/**
 * @covers Email
 */
final class CSVImporterTest extends TestCase {

    public function providergetCSV() {
        return [
            [1, true, 1, true, false],
            [1, false, 0, null, false],
            [1, true, 1, false, true],
        ];
    }

    /**
     * @dataProvider providergetCSV
     * @param type $expectHandleIsValidCount
     * @param type $handleIsValidResult
     * @param type $expectgetCSVCount
     * @param type $getCSVResult
     */
    public function testGetCSV($expectHandleIsValidCount, $handleIsValidResult, $expectgetCSVCount, $getCSVResult, $expectException) {
        $sut = $this->createPartialMock('Importers\\CSVImporter', array('fileHandleIsValid', 'getCSV', 'clearData'));
        $sut->method('fileHandleIsValid')->willReturn($handleIsValidResult);
        $sut->method('getCSV')->willReturn($getCSVResult);
        $sut->method('clearData')->willReturn($getCSVResult);

        $sut->expects($this->exactly($expectHandleIsValidCount))->method('fileHandleIsValid');
        $sut->expects($this->exactly($expectgetCSVCount))->method('getCSV');
        $sut->expects($this->exactly(1))->method('clearData');


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
                ->setMethods(array('fileHandleIsValid', 'getCSV', 'clearData'))
                ->disableOriginalClone()
                ->setConstructorArgs(array($filePath, $delimiter, $enclosure, $escape))
                ->disableArgumentCloning()
                ->disallowMockingUnknownTypes()
                ->getMock();

//        $sut = $this->createPartialMock('Importers\\CSVImporter', array('fileHandleIsValid', 'getCSV', 'clearData'));
        $sut->method('fileHandleIsValid')->willReturn(true);
        $sut->method('getCSV')->willReturn([]);
//        $sut->method('getCSV')->willReturn([]);

        $sut->expects($this->exactly(1))->method('fileHandleIsValid');
        $sut->expects($this->exactly(1))->method('getCSV')->with($this->anything(), $this->equalTo(0), $this->equalTo($delimiter), $this->equalTo($enclosure), $this->equalTo($escape));
        $sut->loadData();
    }

}
