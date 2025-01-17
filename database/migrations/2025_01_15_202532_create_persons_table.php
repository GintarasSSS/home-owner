<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    const TABLE = 'persons';

    public function up(): void
    {
        Schema::create(self::TABLE, function (Blueprint $table) {
            $table->id();
            $table->string('title', 10)->nullable(false);
            $table->string('first_name', 100)->nullable();
            $table->string('initial', 10)->nullable();
            $table->string('last_name', 100)->nullable(false);
            $table->timestamps();

            $table->unique(['title', 'last_name']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists(self::TABLE);
    }
};
