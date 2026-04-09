<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateResearchContentImagesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        if (Schema::hasTable('research_content_images')) {
            return;
        }

        Schema::create('research_content_images', function (Blueprint $table) {
            $table->increments('id');
            $table->string('image');
            $table->integer('research_content_id')->unsigned()->index();
            $table->foreign('research_content_id')->references('id')->on('research_contents')->onDelete('cascade');
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
        if (! Schema::hasTable('research_content_images')) {
            return;
        }

        Schema::drop('research_content_images');
    }
}
