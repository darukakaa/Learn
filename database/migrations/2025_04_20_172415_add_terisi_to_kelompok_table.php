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
        Schema::table('kelompok', function (Blueprint $table) {
            $table->unsignedInteger('terisi')->default(0);
        });
    }

    public function down()
    {
        Schema::table('kelompok', function (Blueprint $table) {
            $table->dropColumn('terisi');
        });
    }
};
