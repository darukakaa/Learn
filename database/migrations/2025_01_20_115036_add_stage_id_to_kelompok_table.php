<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddStageIdToKelompokTable extends Migration
{
    public function up()
    {
        Schema::table('kelompok', function (Blueprint $table) {
            $table->unsignedBigInteger('stage_id')->nullable(); // Tambahkan kolom stage_id
        });
    }

    public function down()
    {
        Schema::table('kelompok', function (Blueprint $table) {
            $table->dropColumn('stage_id'); // Hapus kolom stage_id
        });
    }
}
