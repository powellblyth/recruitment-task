<?php

declare(strict_types = 1);

use PHPUnit\Framework\TestCase;

/**
 * @covers Command
 */
final class CommandTest extends TestCase {

    public function providerrequiredFieldsPresent() {
        return [
            [true, ["filetype"=> "csv","filename"=>"./data/file.csv"], ['filetype:', 'filename:', 'separator::', 'delimiter::', 'escapecharacter::']],
            [false, ["filetype"=> "csv","separator"=>";"], ['filetype:', 'filename:', 'separator::', 'delimiter::', 'escapecharacter::']], //missing filename
            [false, ["delimiter"=> "-","filename"=>"./data/file.csv"], ['filetype:', 'filename:', 'separator::', 'delimiter::', 'escapecharacter::']], //missing filetype
            [true, ["filetype"=> "csv","filename"=>"./data/file.csv","extra"=>"somehtingelse"], ['filetype:', 'filename:', 'separator::', 'delimiter::', 'escapecharacter::']],
        ];
    }

    /**
     * @dataProvider providerrequiredFieldsPresent
     * @param bool $expected
     * @param string $options
     * @param array $longOptions
     */
    public function testrequiredFieldsPresent($expected, $getOptsValue, $longOptions) {
        $sut = $this->getMockForAbstractClass('\Commands\Command', [], '', true, true, true, ['getUserOptions','getLongOptions']);
        
        $sut->method('getUserOptions')->will($this->returnValue($getOptsValue));
        $sut->method('getLongOptions')->will($this->returnValue($longOptions));
        $this->assertSame($expected, $sut->requiredFieldsPresent());
    }

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
