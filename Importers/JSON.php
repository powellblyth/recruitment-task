<?php

namespace Importers;

class JSON extends Base {

//STUB
    public function __construct(string $filePath) {
        throw new ImporterException("JSON Importer is not complete and cannot be used. Please try a different format $filePath");
    }

    public function loadData(): array {
        return [];
    }

}
