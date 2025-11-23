<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('favorite_quotations', function (Blueprint $table) {
            $table->id();
            $table->string('device_id'); // Device unique identifier
            $table->foreignId('quotation_id')->constrained()->onDelete('cascade'); // Relation to quotation
            $table->timestamps();

            $table->unique(['device_id', 'quotation_id']); // Prevent duplicate save
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('favorite_quotations');
    }
};
