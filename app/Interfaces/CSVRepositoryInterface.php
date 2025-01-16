<?php

namespace App\Interfaces;

use Illuminate\Support\Collection;

interface CSVRepositoryInterface
{
    public function parseCSV(string $filePath): Collection;
}
