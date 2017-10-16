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
            ['\\Importers\\CSV', false, 'csv'],
            ['\\Importers\\CSV', false, 'CSV'], //check case sensitivity
            ['\\Importers\\CSV', false, 'CsV'],
            [null, true, 'CsVchunked'],
            ['\\Importers\\XML', false, 'xml'],
            ['\\Importers\\Yaml', false, 'yml'],
            ['\\Importers\\Yaml', false, 'yaml'],
            [null, true, 'json'],
            [null, false, 'sausages'],
        ];
    }

    /**
     * @dataProvider providergetImporter
     */
    public function testgetImporter($expectedClass, bool $expectException, string $filetype) {

        if ($expectException) {
            $this->expectException('\Importers\ImporterException');
        }
        
        $importer = \Importers\Factory::getImporter($filetype, __FILE__);
        if (!is_null($expectedClass)) {
            $this->assertInstanceOf($expectedClass, $importer);
        } else {
            $this->assertNull($expectedClass, $importer);
        }
    }

}
