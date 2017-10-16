<?php
namespace Outputters;
/**
 * NOTE this class is not yet implemented, for brevity
 */
class File extends Base
{
    function outputData():bool
    {
        echo "\n\nFILE OUTPUT NOT YET IMPLEMENTED\n".sprintf($this->message, $this->dataPoint)."\n\n";
        return true;
    }
}

