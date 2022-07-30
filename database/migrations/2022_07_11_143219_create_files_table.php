<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateFilesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('files', function (Blueprint $table) {
            $table->increments('id');
            $table->string('filename_path');
            $table->string('filename');
            $table->string('filename_extension');

            $table->string('artist');
            $table->string('album');
            $table->string('title');

            $table->string('date_time_original');

        });

        /*Schema::create('file_', function (Blueprint $table) {
            $table->increments('id');
            $table->string('filename_path');
            $table->string('filename');
            $table->string('filename_extension');
        });*/
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('files');
    }
}
