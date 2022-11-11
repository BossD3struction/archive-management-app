<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateJpgFilesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('jpg_files', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('filename_path');
            $table->string('filename');
            $table->string('title');
            $table->string('tags');
            $table->string('comments');
            $table->string('date');
            $table->boolean('has_exif_metadata');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('jpg_files');
    }
}
