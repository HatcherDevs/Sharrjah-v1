<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreatePublicationImageSlidesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        if (Schema::hasTable('publication_image_slides')) {
            return;
        }

        Schema::create('publication_image_slides', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('publication_id')->unsigned()->index();
            $table->foreign('publication_id')->references('id')->on('publications')->onDelete('cascade');
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
        if (! Schema::hasTable('publication_image_slides')) {
            return;
        }

        Schema::drop('publication_image_slides');
    }
}
