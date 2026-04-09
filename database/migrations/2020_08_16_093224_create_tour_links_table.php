<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateTourLinksTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        if (Schema::hasTable('tour_links')) {
            return;
        }

        Schema::create('tour_links', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('tour_id')->unsigned()->index();
            $table->foreign('tour_id')->references('id')->on('tours')->onDelete('cascade');
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
        if (! Schema::hasTable('tour_links')) {
            return;
        }

        Schema::drop('tour_links');
    }
}
