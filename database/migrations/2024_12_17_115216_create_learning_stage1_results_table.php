<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateLearningStage1ResultsTable extends Migration
{
    public function up()
    {
        Schema::create('learning_stage1_results', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('learning_stage1_id'); // Relasi ke learning_stage1
            $table->unsignedBigInteger('user_id'); // Relasi ke user
            $table->text('result'); // Kolom untuk menyimpan hasil identifikasi masalah
            $table->timestamps();

            // Menambahkan foreign key constraint
            $table->foreign('learning_stage1_id')->references('id')->on('learning_stage1')->onDelete('cascade');
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
        });
    }

    public function down()
    {
        Schema::dropIfExists('learning_stage1_results');
    }
}
