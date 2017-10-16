<?php

namespace Importers;

/**
 * Processor for CSV files
 */
class Yaml extends Base {

    /**
     * Yaml implementation of the loadData parameter
     * @return boolean
     */
    public function loadData(): array {
        $result = [];
        $data = \Symfony\Component\Yaml\Yaml::parse(file_get_contents($this->filePath));
        if (is_array($data) && array_key_exists('users', $data)) {
            $result = $data['users'];
        }
        return $result;
    }

}
