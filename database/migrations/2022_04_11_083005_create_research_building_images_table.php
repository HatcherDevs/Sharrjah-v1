<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateResearchBuildingImagesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('research_building_images', function (Blueprint $table) {
            $table->increments('id');
            $table->string('image');
            $table->integer('research_building_id')->unsigned()->index();
            $table->foreign('research_building_id')->references('id')->on('research_buildings')->onDelete('cascade');
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
        Schema::drop('research_building_images');
    }
}
