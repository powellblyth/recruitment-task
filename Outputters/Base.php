<?php

namespace Outputters;

abstract class Base implements OutputterInterface {

    protected $dataPoint;
    protected $message = "Result was %s";

    function setDataPoint($dataPoint) {
        $this->dataPoint = $dataPoint;
    }

    function setMessage(string $message) {
        $this->message = $message;
    }

}
