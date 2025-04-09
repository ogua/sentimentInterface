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
        Schema::create('response_answers', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->uuid('response_id');
            $table->uuid('question_id');
            $table->text('answer_text')->nullable();
            $table->timestamps();

            $table->foreign('response_id')->references('id')->on('responses')->onDelete('cascade');
            $table->foreign('question_id')->references('id')->on('questions')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('response_answers');
    }
};
