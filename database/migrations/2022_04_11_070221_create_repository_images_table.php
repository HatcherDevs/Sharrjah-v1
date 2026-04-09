<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateRepositoryImagesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        if (Schema::hasTable('repository_images')) {
            return;
        }

        Schema::create('repository_images', function (Blueprint $table) {
            $table->increments('id');
            $table->string('image');
            $table->integer('repository_id')->unsigned()->index();
            $table->foreign('repository_id')->references('id')->on('repositories')->onDelete('cascade');
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
        if (! Schema::hasTable('repository_images')) {
            return;
        }

        Schema::drop('repository_images');
    }
}
