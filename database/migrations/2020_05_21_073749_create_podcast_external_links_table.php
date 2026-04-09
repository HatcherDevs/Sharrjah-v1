<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreatePodcastExternalLinksTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        if (Schema::hasTable('podcast_external_links')) {
            return;
        }

        Schema::create('podcast_external_links', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('podcast_id')->unsigned()->index();
            $table->foreign('podcast_id')->references('id')->on('podcasts')->onDelete('cascade');
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
        if (! Schema::hasTable('podcast_external_links')) {
            return;
        }

        Schema::drop('podcast_external_links');
    }
}
