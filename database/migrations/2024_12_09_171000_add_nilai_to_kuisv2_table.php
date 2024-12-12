<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('kuisv2', function (Blueprint $table) {
            // Menambahkan kolom nilai dengan tipe data decimal
            $table->decimal('nilai', 5, 2)->nullable()->after('tanggal_kuis');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('kuisv2', function (Blueprint $table) {
            $table->dropColumn('nilai');
        });
    }
};
