<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateOpportunitiesImageSlidesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        if (Schema::hasTable('opportunities_image_slides')) {
            return;
        }

        Schema::create('opportunities_image_slides', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('opportunities_id')->unsigned()->index();
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
        if (! Schema::hasTable('opportunities_image_slides')) {
            return;
        }

        Schema::drop('opportunities_image_slides');
    }
}
