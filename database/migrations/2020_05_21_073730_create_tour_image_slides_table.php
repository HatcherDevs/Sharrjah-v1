<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateTourImageSlidesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        if (Schema::hasTable('tour_image_slides')) {
            return;
        }

        Schema::create('tour_image_slides', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('tour_id')->unsigned()->index();
            $table->foreign('tour_id')->references('id')->on('tours')->onDelete('cascade');
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
        if (! Schema::hasTable('tour_image_slides')) {
            return;
        }

        Schema::drop('tour_image_slides');
    }
}
