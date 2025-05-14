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
            $table->string('band_name')->nullable();
            $table->string('location')->nullable();
            $table->date('date_of_birth')->nullable();
            $table->text('band_bio')->nullable();
            $table->text('genre')->nullable();
            $table->string('phone_number')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn('band_name');
            $table->dropColumn('location');
            $table->dropColumn('date_of_birth');
            $table->dropColumn('band_bio');
            $table->dropColumn('genre');
            $table->dropColumn('phone_number');
        });
    }
};
