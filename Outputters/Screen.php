<?php
namespace Outputters;

class Screen extends Base
{
    /**
     * Simply drops the content on the screen
     * @return boolean
     */
    function outputData():bool
    {
        echo "\n\n".sprintf($this->message, $this->dataPoint)."\n\n";
        return true;
    }
}

