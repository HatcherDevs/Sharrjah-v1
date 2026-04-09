<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateSpaceLinksTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        if (Schema::hasTable('space_links')) {
            return;
        }

        Schema::create('space_links', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('space_id')->unsigned()->index();
            $table->foreign('space_id')->references('id')->on('spaces')->onDelete('cascade');
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
        if (! Schema::hasTable('space_links')) {
            return;
        }

        Schema::drop('space_links');
    }
}
