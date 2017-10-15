<?php

namespace Importers;

/**
 * Processor for CSV files
 */
class XMLImporter extends ImporterBase {

    protected $delimiter = ",";
    protected $enclosure = '"';
    protected $escape = '\\';

    /**
     * 
     * @param string $filePath The correct path to the file
     * @param string $delimiter optional delimeter override
     * @param string $enclosure optional enclosure override
     * @param string $escape optional escape override
     */
    public function __construct(string $filePath, string $delimiter = null, string $enclosure = null, string $escape = null) {
        parent::__construct($filePath);
        if (!is_null($delimiter)) {
            $this->delimiter = $delimiter;
        }
        if (!is_null($enclosure)) {
            $this->enclosure = $enclosure;
        }
        if (!is_null($escape)) {
            $this->escape = $escape;
        }
    }

    /**
     * CSV implementation of the loadData parameter
     * @return boolean
     */
    public function loadData(): bool {
        $state = false;
        $this->clearData();

        if (is_resource($this->fileHandle)) {
            $state = false;
            $this->data = simplexml_load_file($this->fileHandle);
            if ($this->data === false) {
                $state = false;
                throw new ImporterException("Invalid File Format");
            }
        }

        return $state;
    }

}
