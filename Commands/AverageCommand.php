<?php

namespace Commands;

class AverageCommand extends Command {

    protected $longOptions = ['filetype:', 'filename:', 'field:', 'separator::', 'delimiter::', 'escapecharacter::', 'action::'];
    protected $options = '';
    protected $exampleText = 'Correct usage is php scripts/do.php --action=average --filetype=xml|csv|yaml --filename="/path/to/file.extension" --field=value';

    public function execute(): bool {
        $options = $this->getUserOptions();
        $importer = \Importers\Factory::getImporter($options['filetype'], $options['filename']);

        if ($importer instanceof \Importers\ImporterInterface) {
            $dataStore = new \Lib\DataStore();
            $dataStore->setData($importer->loadData());

            $dataManager = new \Lib\DataManager($dataStore);
            $average = $dataManager->averageColumn($options['field']);
            echo "\Average OF " . $options['field'] ." WAS " . $average."\n\n";
            
            return true;
        } else {
            return false;
        }
    }

}
