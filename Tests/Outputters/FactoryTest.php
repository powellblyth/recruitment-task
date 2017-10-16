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
    public function testgetOutputter($expectedClass, $outputType) {
        if (!is_null($expectedClass)) {
            $this->assertInstanceOf($expectedClass, \Outputters\Factory::getOutputter($outputType));
        } else {
            $this->assertNull($expectedClass, \Outputters\Factory::getOutputter($outputType));
        }
    }

}
