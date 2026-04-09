<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateSpaceExternalFilesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        if (Schema::hasTable('space_external_files')) {
            return;
        }

        Schema::create('space_external_files', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('space_id')->unsigned()->index();
            $table->foreign('space_id')->references('id')->on('spaces')->onDelete('cascade');
            $table->string('url');
            $table->string('language');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        if (! Schema::hasTable('space_external_files')) {
            return;
        }

        Schema::drop('space_external_files');
    }
}
