<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateTourExternalFilesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        if (Schema::hasTable('tour_external_files')) {
            return;
        }

        Schema::create('tour_external_files', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('tour_id')->unsigned()->index();
            $table->foreign('tour_id')->references('id')->on('tours')->onDelete('cascade');
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
        if (! Schema::hasTable('tour_external_files')) {
            return;
        }

        Schema::drop('tour_external_files');
    }
}
