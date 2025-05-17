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
        Schema::create('catatan', function (Blueprint $table) {
            $table->id();
            $table->text('isi_catatan');
            $table->string('file_catatan')->nullable();
            $table->foreignId('learning_id')->constrained()->onDelete('cascade');
            $table->foreignId('kelompok_id')->constrained()->onDelete('cascade');
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            $table->timestamps();
        });
    }


    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('catatan');
    }
};
