<?php

namespace Tests\Unit;

use App\Repositories\CSVRepository;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Illuminate\Validation\ValidationException;
use Tests\TestCase;

class CSVRepositoryTest extends TestCase
{
    use DatabaseTransactions;

    protected CSVRepository $repository;

    public function setUp(): void
    {
        parent::setUp();

        $this->repository = new CSVRepository();
    }

    public function testItParsesCsvAndReturnsCorrectCollection(): void
    {
        $filePath = $this->createTestCSV([
            [str()->random(10)],
            ['Mr John Doe'],
            ['Mrs Jane Smith']
        ]);

        $result = $this->repository->parseCSV($filePath);

        $this->assertCount(2, $result);
        $this->assertEquals('Doe', $result->first()['last_name']);
        $this->assertEquals('Smith', $result->last()['last_name']);
    }

    public function testItThrowsExceptionOnEmptyData(): void
    {
        $filePath = $this->createTestCSV([
            [str()->random(10)],
            ['']
        ]);

        $this->expectException(\InvalidArgumentException::class);

        $this->repository->parseCSV($filePath);
    }

    public function testItThrowsExceptionOnInvalidNameData(): void
    {
        $filePath = $this->createTestCSV([
            [str()->random(10)],
            ['Mr John Doe'],
            ['Mrs']
        ]);

        $this->expectException(ValidationException::class);

        $this->repository->parseCSV($filePath);
    }

    /**
     * @dataProvider tooLongNameDataProvider
     */
    public function testItThrowsExceptionOnTooLongNameData(string $name): void
    {
        $filePath = $this->createTestCSV([
            [str()->random(10)],
            ['Mr John Doe'],
            [$name]
        ]);

        $this->expectException(ValidationException::class);

        $this->repository->parseCSV($filePath);
    }

    public function testItHandlesComplexNamesAndSavesValidData(): void
    {
        $filePath = $this->createTestCSV([
            [str()->random(10)],
            ['Dr John Smith'],
            ['Mr and Mrs Smith'],
            ['Prof J. Smith'],
        ]);

        $result = $this->repository->parseCSV($filePath);

        $this->assertCount(4, $result);
        $this->assertDatabaseHas(
            'persons',
            ['title' => 'Dr', 'first_name' => 'John', 'initial' => null, 'last_name' => 'Smith']
        );
        $this->assertDatabaseHas(
            'persons',
            ['title' => 'Mr', 'first_name' => null, 'initial' => null, 'last_name' => 'Smith']
        );
        $this->assertDatabaseHas(
            'persons',
            ['title' => 'Mrs', 'first_name' => null, 'initial' => null, 'last_name' => 'Smith']
        );
        $this->assertDatabaseHas(
            'persons',
            ['title' => 'Prof', 'first_name' => null, 'initial' => 'J', 'last_name' => 'Smith']
        );
    }

    static function tooLongNameDataProvider(): array
    {        return [
            'title_longer_then_10_chars' => ['name' => str()->random(11)],
            'name_longer_then_100_chars' => ['name' => 'Mr ' . str()->random(101)],
        ];
    }

    protected function createTestCSV(array $data): string
    {
        $filePath = storage_path('test.csv');
        $file = fopen($filePath, 'w');

        foreach ($data as $row) {
            fputcsv($file, $row);
        }

        fclose($file);
        return $filePath;
    }
}
