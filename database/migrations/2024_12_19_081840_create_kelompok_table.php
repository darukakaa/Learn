<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateKelompokTable extends Migration
{
    public function up()
    {
        Schema::create('kelompok', function (Blueprint $table) {
            $table->id();
            $table->string('nama_kelompok');
            $table->integer('jumlah_kelompok');
            $table->unsignedBigInteger('learning_id'); // Add learning_id column
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('kelompok');
    }
}
