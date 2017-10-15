<?php

require __DIR__ . '/../vendor/autoload.php';
if ($argc < 2) {
    echo "ERROR invalid paramters. \nCorrect Usage: scripts/do.php <action> [options]\n\n e.g. scripts/do.php summarise --filename=data/file.csv --filetype=csv\n\n";
    exit(1);
} else {
    $command = null;
    $longOptions = ['action:'];

    $opts = getopt('', $longOptions);
    if (array_key_exists('action', $opts)) {
        switch ($opts['action']) {
            case 'summarise':
                $command = new \Commands\SummariseCommand();
                break;
            default:
                ;
                break;
        }
        if ($command instanceof \Commands\Command) {
            if (!$command->requiredFieldsPresent()) {
                echo "\n" . $command->getExampleText() . "\n\n";
                exit(1);
            } else {
                if ($command->execute()) {
                    exit(0);
                } else {
                    echo "\n\nSomething unexpected went wrong when parsing\n\n";
                    exit(1);
                }
            }
        } else {
            echo "\n\nInvalid action passed (" . $opts['action'] . "), please check the command you wish to run, e.g. /scripts/do.php --action=summarise [options]\n\n";
        }
    } else {
        echo "\n\n you must pass in an action, e.g. Script/do.php --action=summarise [options]\n\n";
    }
}
        
