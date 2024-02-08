<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('beers', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('beer_id');
            $table->string('name');
            $table->string('tagline')->nullable();
            $table->string('first_brewed')->nullable();
            $table->text('description')->nullable();
            $table->text('image_url')->nullable();
            $table->float('abv')->nullable();
            $table->float('ibu')->nullable();
            $table->float('target_fg')->nullable();
            $table->float('target_og')->nullable();
            $table->float('ebc')->nullable();
            $table->float('srm')->nullable();
            $table->float('ph')->nullable();
            $table->float('attenuation_level')->nullable();
            $table->json('volume')->nullable();
            $table->json('boil_volume')->nullable();
            $table->json('method')->nullable();
            $table->json('ingredients')->nullable();
            $table->text('brewers_tips')->nullable();
            $table->string('contributed_by')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('beers');
    }
};
