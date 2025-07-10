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
        Schema::table('materiv2', function (Blueprint $table) {
            $table->text('deskripsi')->nullable();
            $table->text('tujuan')->nullable();
            $table->text('capaian')->nullable();
            $table->string('file_pdf')->nullable();
        });
    }


    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('materiv2', function (Blueprint $table) {
            //
        });
    }
};
