<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTriennial2023ImageSlidesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('triennial2023_image_slides', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('triennial2023_id')->unsigned()->index();
            $table->foreign('triennial2023_id')->references('id')->on('triennial2023s')->onDelete('cascade');
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
        Schema::drop('triennial2023_image_slides');
    }
}
