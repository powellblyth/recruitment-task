<?php

namespace Importers;

/**
 * Abstract base class to hang some OO logic around
 * Doesn't do anything else other than act as a sensible name base
 */
abstract class Factory {

    /**
     * Factory method to get the right command type
     * Note use of nullable type - first PHP7.1 feature
     * 
     * @param string $fileType
     * @param string $fileName
     * @return \Importers\ImporterInterface
     */
    public static function getImporter(string $fileType, string $fileName): ?\Importers\ImporterInterface {
        switch (strToLower($fileType)) {
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
