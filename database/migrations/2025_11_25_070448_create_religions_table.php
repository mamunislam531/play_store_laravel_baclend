<?php

// database/migrations/2025_11_25_000000_create_religions_table.php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('religions', function (Blueprint $table) {
            $table->id();
            $table->string('title');
            $table->string('img')->nullable(); // image path or url
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('religions');
    }
};
