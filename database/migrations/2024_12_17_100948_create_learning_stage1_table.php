<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateLearningStage1Table extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('learning_stage1', function (Blueprint $table) {
            $table->id(); // Primary key
            $table->unsignedBigInteger('learning_id'); // Relasi ke tabel learnings
            $table->string('problem'); // Menyimpan teks permasalahan
            $table->string('file'); // Menyimpan path file gambar
            $table->timestamps(); // created_at dan updated_at

            // Foreign key ke tabel learnings
            $table->foreign('learning_id')->references('id')->on('learnings')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('learning_stage1');
    }
}
