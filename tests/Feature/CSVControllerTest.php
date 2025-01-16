<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\DatabaseTransactions;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Tests\TestCase;

class CSVControllerTest extends TestCase
{
    use DatabaseTransactions;

    public function testItShowsTheHomePage()
    {
        $response = $this->get(route('home'));
        $response->assertStatus(200);
        $response->assertViewIs('index');
    }

    public function testItUploadsValidCsvFileAndShowsSuccessMessage(): void
    {
        Storage::fake('local');
        $file = UploadedFile::fake()->createWithContent(
            'test.csv',
            "title,\nMr John Doe\nMrs Jane-Doe"
        );

        $response = $this->post(route('upload-csv'), ['file' => $file]);

        $response->assertRedirect(route('home'));
        $response->assertSessionHas('success', 'File uploaded successfully');
    }

    public function testItHandlesUploadOfInvalidCsvFile(): void
    {
        $file = UploadedFile::fake()->createWithContent('test.csv', "invalid,content");

        $response = $this->post(route('upload-csv'), ['file' => $file]);

        $response->assertRedirect(route('home'));
        $response->assertSessionHasErrors();
    }

    public function testItHandlesMissingCsvFileUpload(): void
    {
        $response = $this->post(route('upload-csv'), []);
        $response->assertRedirect(route('home'));
        $response->assertSessionHasErrors();
    }
}
