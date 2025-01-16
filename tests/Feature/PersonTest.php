<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\DatabaseTransactions;
use Tests\TestCase;
use App\Models\Person;

class PersonTest extends TestCase
{
    use DatabaseTransactions;

    public function testDatabaseHasPerson(): void
    {
        Person::factory()->create([
            'title' => 'Mr',
            'initial' => 'JD',
            'first_name' => 'John',
            'last_name' => 'Doe',
        ]);

        $this->assertDatabaseHas('persons', [
            'title' => 'Mr',
            'initial' => 'JD',
            'first_name' => 'John',
            'last_name' => 'Doe',
        ]);
    }
}
