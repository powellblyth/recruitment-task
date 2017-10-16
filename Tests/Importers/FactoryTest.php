<?php

declare(strict_types = 1);

namespace Tests\Importers;

use PHPUnit\Framework\TestCase;

/**
 * @covers Email
 */
final class FactoryTest extends TestCase {

    public function providergetImporter() {
        return [
            ['\\Importers\\CSV', false, 'data.csv'],
            ['\\Importers\\CSV', false, 'data.CSV'], //check case sensitivity
            ['\\Importers\\CSV', false, 'data.CsV'],
            [null, true, 'data.CsVchunked'],
            ['\\Importers\\XML', false, 'data.xml'],
            ['\\Importers\\Yaml', false, 'data.yml'],
            ['\\Importers\\Yaml', false, 'data.yaml'],
            [null, true, 'data.json'],
            [null, false, 'data.sausages'],
        ];
    }

    /**
     * @dataProvider providergetImporter
     */
    public function testgetImporter($expectedClass, bool $expectException, string $fileName) {

        if ($expectException) {
            $this->expectException('\Importers\ImporterException');
        }
        
        $importer = \Importers\Factory::getImporter($fileName);
        if (!is_null($expectedClass)) {
            $this->assertInstanceOf($expectedClass, $importer);
        } else {
            $this->assertNull($expectedClass, $importer);
        }
    }

    
    public function providergetFileType()
    {
        return [
            ['csv','bob.csv'],
            ['yaml','bob.yaml'],
            ['xml','/path/to/data.xml'],
            ['json','/bonkers.path/to/data.file.json'],
            ['','bobcsv']
            ];
    }
    
    /**
     * @dataProvider providergetFileType
     * @param string $expected
     * @param string $fileName
     */
    public function testgetFileType(string $expected, string $fileName)
    {
        $sut = $this->createMock('\Importers\Factory');
$class = new \ReflectionClass($sut);
        $method = $class->getMethod('getFileType');
        $method->setAccessible(true);
        $handle = $method->invokeArgs($sut, [$fileName]);
        $this->assertSame($expected, $handle);
    }
            
}
