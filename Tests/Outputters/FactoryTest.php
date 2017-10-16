<?php

declare(strict_types = 1);

namespace Tests\Outputters;

use PHPUnit\Framework\TestCase;

/**
 * @covers Email
 */
final class FactoryTest extends TestCase {

    public function providergetOutPutter() {
        return [
            ['\\Outputters\\File', 'File'],
            ['\\Outputters\\File', 'fiLE'], //check case sensitivity
            ['\\Outputters\\Screen', 'screen'],
            [null, 'bananas'],
        ];
    }

    /**
     * @dataProvider providergetOutputter
     */
    public function testgetOutputter($expectedClass, $filetype) {
        if (!is_null($expectedClass)) {
            $this->assertInstanceOf($expectedClass, \Outputters\Factory::getOutputter($filetype));
        } else {
            $this->assertNull($expectedClass, \Outputters\Factory::getOutputter($filetype));
        }
    }

}
