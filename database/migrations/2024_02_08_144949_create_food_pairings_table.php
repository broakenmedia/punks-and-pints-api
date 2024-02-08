<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('food_pairings', function (Blueprint $table) {
            $table->id();
            $table->foreignId('beer_id')->constrained()->onDelete('cascade');
            $table->string('pairing');
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('food_pairings');
    }
};
