<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up()
    {
        Schema::create('questionsv2', function (Blueprint $table) {
            $table->id();
            $table->foreignId('kuis_id')->constrained('kuisv2')->onDelete('cascade');
            $table->text('question');
            $table->string('option_a');
            $table->string('option_b');
            $table->string('option_c');
            $table->string('option_d');
            $table->string('option_e');
            $table->char('correct_answer', 1);
            $table->string('image')->nullable(); // Add this field for storing image file path
            $table->timestamps();
        });
    }


    public function down()
    {
        Schema::dropIfExists('questionsv2');
    }
};
