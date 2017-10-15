<?php

namespace Importers;

/**
 * Processor for CSV files
 */
class XMLImporter extends ImporterBase {

    public function getFile(string $filePath): bool {
        // We are using a more direct yaml parser, no need to 
        // use the inherited file handle management
        return true;
    }

    /**
     * CSV implementation of the loadData parameter
     * @return boolean
     */
    public function loadData(): array {

        $result = [];
        if (is_file($this->filePath)) {
            $data = simplexml_load_file($this->filePath);
            if ($data === false) {// || !is_array($data) || !array_key_exists('user', $data)) {
                throw new ImporterException("Invalid File Format");
            } else {
                $this->data = [];
                foreach ($data->user as $user) {
                    $result[] = ["name" => (string) $user->name, "active" => (string) $user->active, "value" => (string) $user->value];
                }
            }
        }

        return $result;
    }

}
