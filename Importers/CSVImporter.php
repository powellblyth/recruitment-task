<?php

namespace Importers;

/**
 * Processor for CSV files
 */
class CSVImporter extends ImporterBase {

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

        if ($this->fileHandleIsValid()) {
            $state = false;
            $this->data = $this->getCSV($this->fileHandle, 0, $this->delimiter, $this->enclosure, $this->escape);
            if ($this->data === false) {
                throw new \Exceptions\ImporterException("Invalid File Format");
            }
        }

        return $state;
    }

    /**
     * wrapper to allow testing
     * @return bool
     */
    protected function fileHandleIsValid(): bool {
        return is_resource($this->fileHandle);
    }

    /**
     * Break this out for unit testability
     */
    protected function getCSV($fileHandle, $delimiter, $enclosure, $escape) {
        return fgetcsv($fileHandle, 0, $delimiter, $enclosure, $escape);
    }

}
