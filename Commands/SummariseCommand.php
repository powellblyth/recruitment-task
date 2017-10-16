<?php

namespace Commands;

/**
 * @TODO Commands should be refactored to re-use more of this code
 */
class SummariseCommand extends Command {

    protected $longOptions = ['filetype:', 'filename:', 'field:', 'separator::', 'delimiter::', 'escapecharacter::', 'action::', 'output::'];
    protected $options = '';
    protected $exampleText = 'Correct usage is php scripts/do.php --action=summarise --filetype=xml|csv|yaml --filename="/path/to/file.extension" --field=value --output=file|screen';

    public function execute(): bool {
        $options = $this->getUserOptions();
        $importer = \Importers\Factory::getImporter($options['filetype'], $options['filename']);
        $outputter = \Outputters\Factory::getOutputter(isset($options['output']) ? $options['output'] : 'screen');

        if ($importer instanceof \Importers\ImporterInterface && $outputter instanceof \Outputters\OutputterInterface) {
            $dataStore = new \Lib\DataStore();
            $dataStore->setData($importer->loadData());

            $dataManager = new \Lib\DataManager($dataStore);
            $total = $dataManager->totaliseColumn($options['field']);

            $outputter->setDataPoint($total);
            $outputter->setMessage("TOTAL OF " . $options['field'] . " WAS %d");
            return $outputter->outputData();
        } else {
            return false;
        }
    }

}
