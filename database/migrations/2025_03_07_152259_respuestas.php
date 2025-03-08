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
        Schema::create('answers', function (Blueprint $table) {
            $table->id('id_answer');
            $table->foreignId('id_survey')->constrained('surveys', 'id_survey')->onDelete('cascade'); // Agregado para referenciar la tabla surveys
            $table->foreignId('id_user')->nullable()->constrained('users', 'id_user')->onDelete('cascade');
            $table->foreignId('id_question')->constrained('questions', 'id_question')->onDelete('cascade');
            $table->foreignId('id_option')->nullable()->constrained('options', 'id_option')->onDelete('set null'); // para multiple_option o rate
            $table->text('answer_text')->nullable(); // para open
            $table->timestamp('answer_date')->useCurrent();
            $table->timestamps();
        });
        
        
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('answers');
    }
};
