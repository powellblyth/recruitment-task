<?php

namespace Importers;
use Symfony\Component\Yaml\Yaml;
/**
 * Processor for CSV files
 */
class YamlImporter extends Base {

    /**
     * Yaml implementation of the loadData parameter
     * @return boolean
     */
    public function loadData(): array {
        $result = [];
        $data = Yaml::parse(file_get_contents($this->filePath));
        if (is_array($data) && array_key_exists('users', $data))
        {
            $result = $data['users'];
        }
        return $result;
        
    }

}
