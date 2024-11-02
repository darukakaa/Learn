<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTugasFilesTable extends Migration
{
    public function up()
    {
        Schema::create('tugas_files', function (Blueprint $table) {
            $table->id();
            $table->foreignId('tugas_id')->constrained('tugas')->onDelete('cascade'); // Links to the Tugas table
            $table->foreignId('user_id')->constrained('users')->onDelete('cascade'); // Links to the User table
            $table->string('file_path'); // Stores the path of the uploaded file
            $table->timestamp('uploaded_at')->useCurrent(); // Stores upload date and time
            $table->timestamps();
        });
        
    }
    

    public function down()
    {
        Schema::dropIfExists('tugas_files');
    }
}
