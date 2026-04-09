<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateStoreWorkshopExternalFilesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        if (Schema::hasTable('store_workshop_external_files')) {
            return;
        }

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
        if (! Schema::hasTable('store_workshop_external_files')) {
            return;
        }

        Schema::drop('store_workshop_external_files');
    }
}
