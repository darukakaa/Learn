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
        Schema::create('penugasan_users', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('user_id');
            $table->unsignedBigInteger('learning_id');
            $table->unsignedBigInteger('kelompok_id');
            $table->string('nama_penugasan');
            $table->string('file');
            $table->timestamps();

            // Foreign key optional (kalau kamu pakai constraint)
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
            $table->foreign('learning_id')->references('id')->on('learnings')->onDelete('cascade');
            $table->foreign('kelompok_id')->references('id')->on('kelompok')->onDelete('cascade');
        });
    }
};
