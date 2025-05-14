<?php

use App\Models\Music;
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
        Schema::table('spotify_tracks', function (Blueprint $table) {
            $table->foreignIdFor(Music::class, 'music_id')->nullable()->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('spotify_tracks', function (Blueprint $table) {
            //
        });
    }
};
