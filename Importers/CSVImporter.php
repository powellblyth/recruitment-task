<?php

namespace Importers;

/**
 * Processor for CSV files
 */
class CSVImporter extends ImporterBase {

    protected $fileHandle;
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

    public function getFile(string $filePath): bool {
        $this->clearFileHandle();
        // Casual prevention of relative paths, should ward off some nastiness. 
        // @TODO make this better
        if ($this->fileIsReal($filePath) && false === strpos($filePath, '../')) {
            try {
                $this->fileHandle = $this->getFileHandle($filePath);
            } catch (Exception $ex) {
                //@todo log this somwhere or handle specific cases
                ; // Do nothing, we are already clear. 
                // If an exception was thrown, fileHandle will now not be a resource
            }
        }
        return is_resource($this->fileHandle);
    }

    /**
     * Testability function to get a filehandle
     * @param string $filePath
     * @return handle
     */
    protected function getFileHandle(string $filePath) {
        // suppress errors, we will check success afterwards
        return @fopen($filePath, 'r');
    }

    /**
     * Ensure we don't accidentally retain a file handle
     */
    public function __destruct() {
        $this->clearFileHandle();
    }

    // Closes the file handle
    public function clearFileHandle() {
        //@TODO improve error handling if closing fails
        if (is_resource($this->fileHandle)) {
            fclose($this->fileHandle);
        }
    }

    /**
     * CSV implementation of the loadData parameter
     * @return boolean
     */
    public function loadData(): array {
        $result = [];

        $this->getFile($this->filePath);

        if ($this->fileHandleIsValid()) {
            $data = $this->getCSV($this->fileHandle, $this->delimiter, $this->enclosure, $this->escape);
            if (is_array($data)) {
                $result = $data;
            } else {
//                var_dump($data);
                throw new \Exceptions\ImporterException("Invalid File Format");
            }
        }

        return $result;
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
     * 
     * @param resource $fileHandle
     * @param string $delimiter
     * @param string $enclosure
     * @param string $escape
     * @return array
     */
    protected function getCSV($fileHandle, string $delimiter, string $enclosure, string $escape): ?array {
        // GEt the header
        $headers = fgetcsv($fileHandle, 0, $delimiter, $enclosure, $escape);
        $resultdata = [];
        // Loop over each line
        while (!feof($fileHandle)) {
            // grab the row
            $inputRow = fgetcsv($fileHandle, 0, $delimiter, $enclosure, $escape);
            if (false !== $inputRow)
            {
                $newDataRow = [];
                foreach ($inputRow as $counter => $rowItem) {
                    $newDataRow[$headers[$counter]] = $rowItem;
                }
                $resultdata[] = $newDataRow;
            }
        }
        return $resultdata;
    }

    public function summarise($field) {
        var_dump($this->data);
    }

}
