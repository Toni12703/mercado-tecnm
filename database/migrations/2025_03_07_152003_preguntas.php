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
        Schema::create('questions', function (Blueprint $table) {
            $table->id('id_question');
            $table->foreignId('id_survey')->constrained('surveys', 'id_survey')->onDelete('cascade');
            $table->text('text_question');
            $table->enum('answer_type', ['text', 'multiple', 'rate']);
            $table->json('attributes');
            $table->timestamps();
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
