<?php
namespace Importers;
interface ImporterInterface
{
    public function __construct(string $filePath);
    
    public function loadData(): array;
}