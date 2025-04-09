<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('questions', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->uuid('survey_id');
            $table->text('question_text')->nullable();
            $table->enum('question_type', ['text', 'rating', 'multiple_choice','single_choice']);
            $table->integer('rating_scale')->nullable(); // For rating questions
            $table->json('options')->nullable(); // For multiple choice
            $table->boolean('is_required')->default(false);
            $table->timestamps();

            $table->foreign('survey_id')->references('id')->on('surveys')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('questions');
    }
};
