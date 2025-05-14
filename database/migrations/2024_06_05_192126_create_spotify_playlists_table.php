<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

use App\Models\OfferTemplate;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('spotify_playlists', function (Blueprint $table) {
            $table->id();
            $table->foreignIdFor(OfferTemplate::class);
            $table->string('playlist_name');
            $table->string('playlist_url', 500);
            $table->integer('song_position');
            $table->integer('days_of_display');
            $table->text('description');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('spotify_playlists');
    }
};
