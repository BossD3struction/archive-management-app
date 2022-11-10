<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateMp3FilesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('mp3_files', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('filename_path');
            $table->string('filename');
            $table->string('title');
            $table->string('artist');
            $table->string('album');
            $table->string('year');
            $table->string('genre');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('mp3_files');
    }
}
