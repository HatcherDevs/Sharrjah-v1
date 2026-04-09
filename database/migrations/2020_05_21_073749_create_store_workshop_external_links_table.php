<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateStoreWorkshopExternalLinksTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        if (Schema::hasTable('store_workshop_external_links')) {
            return;
        }

        Schema::create('store_workshop_external_links', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('store_workshop_id')->unsigned()->index();
            $table->foreign('store_workshop_id')->references('id')->on('store_workshops')->onDelete('cascade');
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
        if (! Schema::hasTable('store_workshop_external_links')) {
            return;
        }

        Schema::drop('store_workshop_external_links');
    }
}
