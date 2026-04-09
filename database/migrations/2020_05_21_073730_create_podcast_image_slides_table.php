<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreatePodcastImageSlidesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        if (Schema::hasTable('podcast_image_slides')) {
            return;
        }

        Schema::create('podcast_image_slides', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('podcast_id')->unsigned()->index();
            $table->foreign('podcast_id')->references('id')->on('podcasts')->onDelete('cascade');
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
        if (! Schema::hasTable('podcast_image_slides')) {
            return;
        }

        Schema::drop('podcast_image_slides');
    }
}
