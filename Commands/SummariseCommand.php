<?php

namespace Commands;

class SummariseCommand extends Command {

    protected $longOptions = ['filetype:', 'filename:', 'field:', 'separator::', 'delimiter::', 'escapecharacter::', 'action::'];
    protected $options = '';
    protected $exampleText = 'Correct usage is php scripts/do.php --action=summarise --filetype=xml|csv|json --filename="/path/to/file.extension" --field=value';

    public function execute(): bool {
        $options = $this->getUserOptions();
        $importer = \Importers\Factory::getImporter($options['filetype'], $options['filename']);

        if ($importer instanceof \Importers\ImporterInterface) {
            $dataStore = new \Lib\DataStore();
            $dataStore->setData($importer->loadData());

            $dataManager = new \Lib\DataManager($dataStore);
            $total = $dataManager->totaliseColumn($options['field']);
            echo "\nTOTAL OF " . $options['field'] ." WAS " . $total."\n\n";
            
            return true;
        } else {
            return false;
        }
    }

}
