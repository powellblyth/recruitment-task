<?php

namespace Importers;

/**
 * Abstract base class to hang some OO logic around
 * Doesn't do anything else other than act as a sensible name base
 */
abstract class Factory {

    protected static function getFileType(string $fileName):string
    {
        $fileType = '';
        $dotPos = strrpos($fileName, ".");
        if (false !== $dotPos)
        {
            $fileType = substr($fileName, $dotPos+1, strlen($fileName) - ($dotPos+1));
        }
        return $fileType;
    }
    /**
     * Factory method to get the right command type
     * Note use of nullable type - first PHP7.1 feature
     * 
     * @param string $fileType
     * @param string $fileName
     * @return \Importers\ImporterInterface
     */
    public static function getImporter(string $fileName): ?\Importers\ImporterInterface {
        switch (strToLower(self::getFileType($fileName))) {
            case 'csv':
                $object = new \Importers\CSV($fileName);
                break;
            case 'csvchunked':
                $object = new \Importers\CSVChunked($fileName);
                break;
            case 'xml':
                $object = new \Importers\XML($fileName);
                break;
            case 'json':
                $object = new \Importers\JSON($fileName);
                break;
            case 'yml':
            case 'yaml':
                $object = new \Importers\Yaml($fileName);
                break;
            default:
                $object = null;
                break;
        }
        return $object;
    }

}
