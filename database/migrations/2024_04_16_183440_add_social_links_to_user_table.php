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
        Schema::table('users', function (Blueprint $table) {
            $table->string('facebook_link')->nullable();
            $table->string('instagram_link')->nullable();
            $table->string('spotify_link')->nullable();
            $table->string('tiktok_link')->nullable();
            $table->string('youtube_link')->nullable();
            $table->string('soundcloud_link')->nullable();
            $table->string('songkick_link')->nullable();
            $table->string('bandcamp_link')->nullable();
            $table->string('telegram')->nullable();
            $table->string('twitter_link')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn('facebook_link');
            $table->dropColumn('instagram_link');
            $table->dropColumn('spotify_link');
            $table->dropColumn('tiktok_link');
            $table->dropColumn('youtube_link');
            $table->dropColumn('soundcloud_link');
            $table->dropColumn('songkick_link');
            $table->dropColumn('bandcamp_link');
            $table->dropColumn('telegram');
            $table->dropColumn('twitter_link');
        });
    }
};
