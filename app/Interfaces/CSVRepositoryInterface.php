<?php

namespace App\Interfaces;

interface CSVRepositoryInterface
{
    public function parseCSV(string $filePath): void;
}
