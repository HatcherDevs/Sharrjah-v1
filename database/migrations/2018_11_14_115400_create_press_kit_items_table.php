<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreatePressKitItemsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        if (Schema::hasTable('press_kit_items')) {
            return;
        }

        Schema::create('press_kit_items', function (Blueprint $table) {
            $table->increments('id');
            $table->string('title');
            $table->string('title_ar');
            $table->integer('press_kit_id')->unsigned()->index();
            $table->foreign('press_kit_id')->references('id')->on('press_kits')->onDelete('cascade');
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
        if (! Schema::hasTable('press_kit_items')) {
            return;
        }

        Schema::drop('press_kit_items');
    }
}
