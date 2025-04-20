<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        // Membuat tabel pivot 'user_kelompok_learning'
        Schema::create('user_kelompok_learning', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('user_id');
            $table->unsignedBigInteger('kelompok_id');
            $table->unsignedBigInteger('learning_id');
            $table->timestamps();

            // Menambahkan foreign key
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
            $table->foreign('kelompok_id')->references('id')->on('kelompok')->onDelete('cascade');
            $table->foreign('learning_id')->references('id')->on('learnings')->onDelete('cascade');

            // Mengatur agar user hanya bisa gabung di 1 kelompok per learning
            $table->unique(['user_id', 'learning_id']);
        });
    }

    public function down(): void
    {
        // Menghapus tabel pivot
        Schema::dropIfExists('user_kelompok_learning');
    }
};
