<?php

namespace Outputters;

interface OutputterInterface {

    public function setDataPoint($dataPoint);

    public function setMessage(string $message);

    public function outputData():bool;
}
