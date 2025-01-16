<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use App\Interfaces\CSVRepositoryInterface;
use App\Repositories\CSVRepository;

class RepositoryServiceProvider extends ServiceProvider
{
    public function register(): void
    {
        $this->app->bind(CSVRepositoryInterface::class, CSVRepository::class);
    }
}
