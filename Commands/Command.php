<?php
namespace Commands;

/**
 * Base Command class
 */
abstract class Command
{
    protected $options;
    protected $longOptions;
    protected $exampleText;
    
    /**
     * Factory method to get the right command type
     * @param string $fileType
     * @param string $fileName
     */
    public static function getImporter(string $fileType, string $fileName): \Importers\ImporterBase
    {
        switch(strToLower($fileType))
        {
            case 'csv':
                $object = new \Importers\CSVImporter($fileName);
                break;
            case 'xml':
                $object = new \Importers\XMLImporter($fileName);
                break;
            case 'json':
                $object = new \Importers\JSONImporter($fileName);
                break;
            default:
                $object = null;
                break;
        }
        return $object;
    }
    
    public function getOptions():string
    {
        return $this->options;
    }
    
    public function getLongOptions():array
    {
        return $this->longOptions;
    }
    public function getExampleText():string
    {
        return $this->exampleText;
    }
    
    public function getUserOptions():array
    {
        return getopt (  $this->getOptions(), $this->getLongOptions() );
    }
    
    abstract public function execute():bool;
  
    /**
     * Check if all required fields are present for this command
     * @return boolean
     */
    public function requiredFieldsPresent():bool
    {
        $result = true;
        $userOptions = $this->getUserOptions();
        foreach ($this->getLongOptions() as $option)
        {
            $optionPlain = rtrim($option,":");
            // If it ends with : but not :: then it is required
            if (false === strpos($option, '::')
                    && strlen($option) === strpos($option, ':') 
                    && !array_key_exists($optionPlain, $userOptions))
            {
                $result = false;
            }
        }
        
        return $result;
    }
}

