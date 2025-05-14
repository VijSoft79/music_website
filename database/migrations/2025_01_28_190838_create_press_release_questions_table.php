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
        Schema::create('press_release_questions', function (Blueprint $table) {
            $table->id();
            $table->foreignIdFor(Music::class);
            $table->text('question0');
            $table->text('question1');
            $table->text('question2');
            $table->text('question3');
            $table->text('question4');
            $table->text('question5');
            $table->text('question6');
            $table->text('question7');

            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('press_release_questions');
    }
};
