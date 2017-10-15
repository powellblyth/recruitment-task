<?php

declare(strict_types = 1);

use PHPUnit\Framework\TestCase;

/**
 * @covers Email
 */
final class CommandTest extends TestCase {

    public function testclearData() {
        $sut = $this->getMockForAbstractClass('\Commands\Command', [], '', true, true, true, []);
        $class = new \ReflectionClass($sut);

        $longOptions = [0 => ['a' => 'b']];
        $reflection_property = $class->getProperty('longOptions');
        $reflection_property->setAccessible(true);
        $reflection_property->setValue($sut, $longOptions);

        $options = 'dsad:sa';
        $reflection_property = $class->getProperty('options');
        $reflection_property->setAccessible(true);
        $reflection_property->setValue($sut, $options);

        $exampleText = 'Example text';
        $reflection_property = $class->getProperty('exampleText');
        $reflection_property->setAccessible(true);
        $reflection_property->setValue($sut, $exampleText);

        $this->assertSame($longOptions, $sut->getLongOptions());
        $this->assertSame($options, $sut->getOptions());
        $this->assertSame($exampleText, $sut->getExampleText());
    }

    // NOTE as this is a demonstration, the rest of this class is not thoroughly tested
}
