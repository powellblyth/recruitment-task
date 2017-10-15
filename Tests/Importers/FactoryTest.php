<?php

declare(strict_types = 1);

namespace Tests;

use PHPUnit\Framework\TestCase;

/**
 * @covers Email
 */
final class FactoryTest extends TestCase {

    public function providergetImporter() {
        return [
            ['\\Importers\\CSVImporter', 'csv'],
            ['\\Importers\\CSVImporter', 'CSV'], //check case sensitivity
            ['\\Importers\\CSVImporter', 'CsV'],
            ['\\Importers\\XMLImporter', 'xml'],
            ['\\Importers\\YamlImporter', 'yml'],
            ['\\Importers\\YamlImporter', 'yaml'],
            ['\\Importers\\JSONImporter', 'json'],
            [null, 'sausages'],
        ];
    }

    /**
     * @dataProvider providergetImporter
     */
    public function testgetImporter($expectedClass, $filetype) {
        if (!is_null($expectedClass)) {
            $this->assertInstanceOf($expectedClass, \Importers\Factory::getImporter($filetype, __FILE__));
        } else {
            $this->assertNull($expectedClass, \Importers\Factory::getImporter($filetype, __FILE__));
        }
    }

}
