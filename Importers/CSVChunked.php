<?php

namespace Importers;

/**
 * Version of the CSV importer for chunking files. DO NOT USE, INCOMPLETE
 */
class CSVChunked extends Base {

    private $dataBuffer;
    private $rowStart;
    private $rowEnd;
    private $bufferSize = 4;

    public function __construct(string $filePath) {
        throw new ImporterException("CSVChunked is not complete and cannot be used. Please use CSV for $filePath");
    }

    public function getRow($line): array {
        if (!$this->hasBuffer() || !$this->isInBuffer($line)) {
            $this->fetchChunk($line, $line + self::$bufferSize);
        }
    }

    /**
     * simple check if we are initialised
     * @return boolean
     */
    protected function hasBuffer(): boolean {
        return (is_array($this->dataBuffer) && is_int($this->rowStart) && is_int($this->rowEnd));
    }

    /**
     * Check if the requested line is within our range
     * @return boolean
     */
    protected function isInBuffer(int $line): boolean {
        return ($this->hasBuffer && $this->rowStart <= $line && $this->rowEnd <= $line);
    }

    protected function fetchChunk(int $start, $lines = null) {
        if (!is_resource($this->fileHandle)) {
            throw new ImporterException("No file handle, initiate handle before fetching data");
        }
        $linesToGet = !is_null($lines) ? $lines : $this->bufferSize;
        $data = fgetcsv($this->fileHandle, ($start + $linesToGet));
    }

    public function loadData(): array {
        return false;
    }

}
