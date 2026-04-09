<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateSpaceImageSlidesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        if (Schema::hasTable('space_image_slides')) {
            return;
        }

        Schema::create('space_image_slides', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('space_id')->unsigned()->index();
            $table->foreign('space_id')->references('id')->on('spaces')->onDelete('cascade');
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
        if (! Schema::hasTable('space_image_slides')) {
            return;
        }

        Schema::drop('space_image_slides');
    }
}
