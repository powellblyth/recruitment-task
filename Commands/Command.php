<?php

namespace Commands;

/**
 * Base Command class
 */
abstract class Command {

    protected $options;
    protected $longOptions;
    protected $exampleText;

    public function getOptions(): string {
        return $this->options;
    }

    public function getLongOptions(): array {
        return $this->longOptions;
    }

    public function getExampleText(): string {
        return $this->exampleText;
    }

    public function getUserOptions(): array {
        return getopt($this->getOptions(), $this->getLongOptions());
    }

    abstract public function execute(): bool;

    /**
     * Check if all required fields are present for this command
     * @return boolean
     */
    public function requiredFieldsPresent(): bool {
        $result = true;
        $userOptions = $this->getUserOptions();
        foreach ($this->getLongOptions() as $option) {
            $optionPlain = rtrim($option, ":");
            // If it ends with : but not :: then it is required
            if (false === strpos($option, '::') && ((strlen($option)-1) === strpos($option, ':'))) {
                // If it is required, check for existance
                if (!array_key_exists($optionPlain, $userOptions)) {
                    $result = false;
                }
            }
        }

        return $result;
    }

}
