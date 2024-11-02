<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddIsValidatedToTugasFilesTable extends Migration
{
    public function up()
    {
        Schema::table('tugas_files', function (Blueprint $table) {
            $table->boolean('is_validated')->default(false); // Add this line
        });
    }

    public function down()
    {
        Schema::table('tugas_files', function (Blueprint $table) {
            $table->dropColumn('is_validated'); // Optionally remove it in the down() method
        });
    }
}

