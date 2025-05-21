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
        Schema::table('catatan', function (Blueprint $table) {
            $table->boolean('is_validated')->default(false)->after('file_catatan');
        });
    }

    public function down()
    {
        Schema::table('catatan', function (Blueprint $table) {
            $table->dropColumn('is_validated');
        });
    }
};
