<?php

declare(strict_types = 1);

namespace Tests;

use PHPUnit\Framework\TestCase;

/**
 * @covers Email
 */
final class ImporterBaseTest extends TestCase {

    public function providergetImporter() {
        return [
            ['\\Importers\\CSVImporter', 'csv'],
            ['\\Importers\\CSVImporter', 'CSV'], //check case sensitivity
            ['\\Importers\\CSVImporter', 'CsV'],
            ['\\Importers\\XMLImporter', 'xml'],
            ['\\Importers\\JSONImporter', 'json'],
            [null, 'sausages'],
        ];
    }

    /**
     * @dataProvider providergetImporter
     */
    public function testgetImporter($expectedClass, $filetype) {
        if (!is_null($expectedClass)) {
            $this->assertInstanceOf($expectedClass, \Importers\ImporterBase::getImporter($filetype, __FILE__));
        } else {
            $this->assertNull($expectedClass, \Importers\ImporterBase::getImporter($filetype, __FILE__));
        }
    }

}
