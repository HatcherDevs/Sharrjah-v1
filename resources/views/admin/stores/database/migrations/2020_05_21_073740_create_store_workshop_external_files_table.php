<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateStoreWorkshopExternalFilesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('store_workshop_external_files', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('store_workshop_id')->unsigned()->index();
            $table->foreign('store_workshop_id')->references('id')->on('store_workshops')->onDelete('cascade');
            $table->string('url');
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
        Schema::drop('store_workshop_external_files');
    }
}
