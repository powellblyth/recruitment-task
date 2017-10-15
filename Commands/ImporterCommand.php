<?php

namespace Commands;

class ImporterCommand extends Command {

    protected $longOptions = ['filetype:', 'filename:', 'separator::', 'delimiter::', 'escapecharacter::'];
    protected $options = '';
    protected $exampleText = 'Correct usage is php Scripts/Summarise.php --filetype=xml|csv|json --filename="/path/to/file.extension" ';

    public function execute():bool {
        $options = $this->getUserOptions();
        $importer = Command::getImporter($options['filetype'], $options['filename']);

//            switch
        return true;
    }

}
