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
        Schema::create('offer_templates', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id');
            $table->tinyInteger('is_active');
            $table->tinyInteger('status');
            $table->tinyInteger('has_premium');
            $table->timestamps();
        });

        Schema::create('basic_offers', function (Blueprint $table) {
            $table->id();
            $table->foreignId('offer_template_id')->onDelete('cascade');
            $table->string('name');
            $table->string('offer_type');
            $table->text('description');
            $table->double('offer_price');
            $table->text('introduction_message');
            $table->timestamps();
        });

        Schema::create('premium_offers', function (Blueprint $table) {
            $table->id();
            $table->foreignId('offer_template_id')->nullable()->onDelete('cascade');
            $table->string('name')->nullable();
            $table->string('offer_type')->nullable();
            $table->text('description')->nullable();
            $table->double('offer_price')->nullable();
            $table->text('introduction_message')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('offer_templates');
        Schema::dropIfExists('basic_offers');
        Schema::dropIfExists('premium_offers');
    }
};
