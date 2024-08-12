<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateModulsTable extends Migration
{
    public function up()
    {
        Schema::create('moduls', function (Blueprint $table) {
            $table->id();
            $table->string('nama_modul');
            $table->string('file_pdf');
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('moduls');
    }
}

