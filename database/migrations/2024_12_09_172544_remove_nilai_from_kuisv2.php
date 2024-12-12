<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class RemoveNilaiFromKuisv2 extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        // Menghapus kolom 'nilai' dari tabel 'kuisv2'
        Schema::table('kuisv2', function (Blueprint $table) {
            $table->dropColumn('nilai');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        // Jika migrasi dibatalkan, menambahkan kolom 'nilai' kembali
        Schema::table('kuisv2', function (Blueprint $table) {
            $table->integer('nilai')->nullable(); // Tipe data dan nullable sesuai dengan kebutuhan
        });
    }
}
