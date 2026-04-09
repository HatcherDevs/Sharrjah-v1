<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateMaterialLinksTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        if (Schema::hasTable('material_links')) {
            return;
        }

        Schema::create('material_links', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('material_id')->unsigned()->index();
            $table->foreign('material_id')->references('id')->on('materials')->onDelete('cascade');
            $table->string('google_url')->nullable();
            $table->string('soundcloud_url')->nullable();
            $table->string('apple_url')->nullable();
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
        if (! Schema::hasTable('material_links')) {
            return;
        }

        Schema::drop('material_links');
    }
}
