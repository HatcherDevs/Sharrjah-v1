<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateResearchBuildingImagesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        if (Schema::hasTable('research_building_images')) {
            return;
        }

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
        if (! Schema::hasTable('research_building_images')) {
            return;
        }

        Schema::drop('research_building_images');
    }
}
