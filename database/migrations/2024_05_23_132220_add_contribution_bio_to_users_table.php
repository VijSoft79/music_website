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
            $table->text('contribution_bio')->after('bio')->nullable();
            $table->integer('estimated_visitor')->after('contribution_bio')->nullable();
            $table->integer('total_reviews')->after('estimated_visitor')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn('contribution_bio');
            $table->dropColumn('estimated_visitor');
            $table->dropColumn('total_reviews');
        });
    }
};
