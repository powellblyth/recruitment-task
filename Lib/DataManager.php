<?php

namespace Lib;

class DataManager {

    protected $dataStore;

    public function __construct(dataStore $dataStore) {
        $this->dataStore = $dataStore;
    }

    function totaliseColumn($columnName) {
        $total = 0;
        if ($this->dataStore->hasData()) {
            foreach ($this->dataStore as $row) {
                $total += $row[$columnName];
            }
        }
        return $total;
    }

    function averageColumn($columnName) {
        $total = 0;
        $counter = 0;
        if ($this->dataStore->hasData()) {
            foreach ($this->dataStore as $row) {
                $counter++;
                $total += $row[$columnName];
            }
        }
        return $total / $counter;
    }

}
