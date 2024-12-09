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
        Schema::create('results', function (Blueprint $table) {
            $table->id();
            $table->foreignId('kuis_id')->constrained('kuisv2')->onDelete('cascade'); // Relasi ke tabel kuis
            $table->foreignId('user_id')->constrained('users')->onDelete('cascade'); // Relasi ke tabel user
            $table->integer('score'); // Nilai atau skor
            $table->timestamps();
        });
    }
    

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('results');
    }
};
