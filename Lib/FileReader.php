<?php

namespace Lib;

/**
 * Abstract Class to manage accessing a file, and providing it to the datamanager
 */
abstract class FileReader extends DataManager implements DataProvider {

    protected $fileHandle;
    protected $rowPointer;
    protected $isLoaded;

    public function __construct(string $filePath) {
        $this->getFile($filePath);
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
     * Simple check if the file is real
     * @param string $filePath
     * @return bool
     */
    protected function fileIsReal(string $filePath): bool {
        return is_file($filePath);
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

}
