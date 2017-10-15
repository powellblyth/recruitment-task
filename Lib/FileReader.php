<?php

namespace Lib;

/**
 * Abstract Class to manage accessing a file, and providing it to the datamanager
 */
abstract class FileReader {

    protected $data;
    protected $filePath;
    protected $rowPointer;
    protected $isLoaded;

    /**
     * abstract function - File Reader doesn't care where the data is from
     */
    abstract public function loadData(): array;    
    
    public function __construct(string $filePath) {
        $this->filePath = $filePath;
    }

    /**
     * Simple check if the file is real
     * @param string $filePath
     * @return bool
     */
    protected function fileIsReal(string $filePath): bool {
        return is_file($filePath);
    }

}
