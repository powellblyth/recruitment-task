<?php

namespace Importers;
use Symfony\Component\Yaml\Yaml;
/**
 * Processor for CSV files
 */
class YamlImporter extends ImporterBase {

    public function getFile(string $filePath):bool
    {
        // We are using a more direct yaml parser, no need to 
        // use the inherited file handle management
        return true;
        
    }
    
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
