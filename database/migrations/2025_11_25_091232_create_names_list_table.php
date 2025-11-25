<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('names_list', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('religion_id'); // relation with religions table
            $table->enum('gender', ['Boy', 'Girl']);   // only Boy/Girl
            $table->string('name_bn');
            $table->string('name_en');
            $table->text('bn_meaning')->nullable();
            $table->timestamps();

            // Foreign Key
            $table->foreign('religion_id')->references('id')->on('religions')->onDelete('cascade');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('names_list');
    }
};
