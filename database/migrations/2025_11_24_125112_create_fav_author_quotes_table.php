<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('fav_author_quotes', function (Blueprint $table) {
            $table->id();
            $table->string('device_id');
            $table->unsignedBigInteger('quote_id');
            $table->timestamps();

            $table->foreign('quote_id')->references('id')->on('author_quotes')->onDelete('cascade');
            $table->unique(['device_id', 'quote_id']); // prevent duplicate favorites
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('fav_author_quotes');
    }
};
