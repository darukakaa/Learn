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
            $table->unsignedBigInteger('learning_id');
            $table->unsignedBigInteger('stage_id');
        });
    }

    public function down()
    {
        Schema::table('kelompok', function (Blueprint $table) {
            $table->dropColumn('learning_id');
            $table->dropColumn('stage_id');
        });
    }
};
