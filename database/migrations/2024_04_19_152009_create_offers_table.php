<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('offers', function (Blueprint $table) {
            $table->id();
            $table->foreignId('music_id');
            $table->foreignId('user_id');
            $table->foreignId('offer_template_id');
            $table->foreignId('status');
            $table->timestamps();
        });

        Schema::create('music_offer', function (Blueprint $table) {
            $table->unsignedBigInteger('music_id');
            $table->unsignedBigInteger('Offer_id');
            $table->foreign('music_id')->references('id')->on('music');
            $table->foreign('Offer_id')->references('id')->on('offers');
        });


    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('offers');
        Schema::dropIfExists('music_offer');
    }
};
