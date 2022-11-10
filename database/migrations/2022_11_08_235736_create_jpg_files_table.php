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
            $table->string('xp_title');
            $table->string('xp_keywords');
            $table->string('xp_comment');
            $table->string('datetime_original');
            $table->string('has_exif_metadata');
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
