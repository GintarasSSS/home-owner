<?php

namespace App\Repositories;

use App\Interfaces\CSVRepositoryInterface;
use App\Models\Person;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\ValidationException;

class CSVRepository implements CSVRepositoryInterface
{
    const PERSONS_PER_PAGE = 10;

    public function getPersons(): LengthAwarePaginator
    {
        return Person::orderBy('id', 'desc')->paginate(self::PERSONS_PER_PAGE);
    }

    public function parseCSV(string $filePath): void
    {
        $rows = array_map('str_getcsv', file($filePath));
        array_shift($rows);
        $data = collect($rows)->map(fn($row) => $row[0]);
        $validated = [];

        if ($data->isEmpty()) {
            throw new \InvalidArgumentException('Invalid data provided.');
        }

        $data->each(function ($row) use (&$validated) {
            if (empty($row)) {
                throw new \InvalidArgumentException('No data provided.');
            }

            $people = $this->parseName($row);

            foreach ($people as $personData) {
                $validated[] = $this->validate($personData);
            }
        });

        if ($validated) {
            Person::insert($validated);
        }
    }

    private function parseName(string $name): array
    {
        $results = [];
        $name = trim($name);
        $splitNames = preg_split('/\s+and\s+|\s*&\s*/i', $name);

        foreach ($splitNames as $individualName) {
            $names = $this->splitNames($individualName);

            $title = $names[0] ?? null;
            $firstName = isset($names[2]) ? $names[1] : null;
            $initial = null;
            $lastName = $names[2] ?? $names[1] ?? null;

            if ($firstName && (strlen($firstName) === 2 && str_contains($firstName, '.') || strlen($firstName) === 1)) {
                $initial = rtrim($firstName, '.');
                $firstName = null;
            }

            if (count($names) === 1 && isset($splitNames[1])) {
                $names = $this->splitNames($splitNames[1]);
                $lastName = $names[2] ?? $names[1] ?? null;
            }

            $results[] = [
                'title' => $title,
                'first_name' => $firstName,
                'initial' => $initial,
                'last_name' => $lastName
            ];
        }

        return $results;
    }

    private function splitNames(string $name): array
    {
        return preg_split('/\s+/', trim($name));
    }

    private function validate(array $personData): array
    {
        $validator = Validator::make($personData, [
            'title' => 'required|string|max:10',
            'first_name' => 'nullable|string|max:100',
            'initial' => 'nullable|string|max:10',
            'last_name' => 'required|string|max:100',
        ]);

        if ($validator->fails()) {
            throw new ValidationException($validator);
        }

        return $validator->validated();
    }
}
