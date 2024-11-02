<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateKuisTable extends Migration
{
    public function up()
    {
        Schema::create('kuis', function (Blueprint $table) {
            $table->id();
            $table->string('nama_kuis');
            $table->date('tanggal_ditambahkan');
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('kuis');
    }
}
