<?php
require __DIR__.'/../vendor/autoload.php';

$command = new Commands\ImporterCommand;

if (!$command->requiredFieldsPresent())
{
    echo "\nCorrect usage is " . $command->getExampleText()."\n";
    exit(1);
}
 else {
    $command->execute();
    exit(0);
}
        
