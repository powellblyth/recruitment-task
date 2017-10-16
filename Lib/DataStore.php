<?php

namespace Lib;

class DataStore implements \Iterator {

    protected $data;
    protected $pointer = 0;

    /**
     * Reset data to zero
     */
    public function clearData() {
        unset($this->data);
    }

    // iterator interface function
    public function valid(): bool {
        return isset($this->data[$this->pointer]);
    }

    public function setData(array $data) {
        $this->clearData();
        $this->data = $data;
    }

    /**
     * check if there is any data
     */
    public function hasData(): bool {
        return is_array($this->data);
    }

    // iterator interface function
    public function current() {
        if ($this->hasData()) {
            if ($this->valid()) {
                return $this->data[$this->pointer];
            }
        }
    }

    // iterator interface function
    public function rewind() {
        $this->pointer = 0;
    }

    // iterator interface function
    public function key() {
        return $this->pointer;
    }

    // iterator interface function
    public function next() {
        if ($this->valid() && is_numeric($this->pointer)) {
            $this->pointer++;
        }
    }

    public function prev() {
        if ($this->hasData && is_numeric($this->pointer) && $this->pointer > 0) {
            $this->pointer--;
        }
    }

    function totaliseColumn($columnName) {
        $total = 0;
        if ($this->hasData()) {
            foreach ($this as $row) {
                $total += $row[$columnName];
            }
        }
        return $column;
    }

}
