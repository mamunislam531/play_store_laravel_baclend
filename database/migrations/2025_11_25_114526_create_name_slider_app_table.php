<?php

// database/migrations/xxxx_create_name_slider_app_table.php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('name_slider_app', function (Blueprint $table) {
            $table->id();
            $table->string('title');
            $table->string('image'); // image path
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('name_slider_app');
    }
};
