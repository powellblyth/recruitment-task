<?php

namespace Outputters;

/**
 * Abstract base class to hang some OO logic around
 * Doesn't do anything else other than act as a sensible name base
 */
abstract class Factory {

    /**
     * Factory method to get the right command type
     * Note use of nullable type - first PHP7.1 feature
     * 
     * @param string $outputterType screen or file
     * @return \Outputters\OutputterInterface
     */
    public static function getOutputter(string $outputterType): ?\Outputters\OutputterInterface {
        switch (strToLower($outputterType)) {
            case 'screen':
                $object = new \Outputters\Screen;
                break;
            case 'file':
                $object = new \Outputters\File();
                break;
            default:
                $object = null;
                break;
        }
        return $object;
    }

}
