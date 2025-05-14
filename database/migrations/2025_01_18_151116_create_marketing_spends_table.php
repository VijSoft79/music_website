<?php

use App\Models\OfferTemplate;
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
        Schema::create('marketing_spends', function (Blueprint $table) {
            $table->id();
            $table->string('name')->nullable();
            $table->foreignIdFor(OfferTemplate::class, 'offertemplate_id');
            $table->double('price');
            $table->enum('offer_type', ['standard','premium']);
            $table->text('description')->nullable();
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('marketing_spends');
    }
};
