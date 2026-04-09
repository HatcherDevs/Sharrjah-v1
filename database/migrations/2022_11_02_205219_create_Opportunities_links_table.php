<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateOpportunitiesLinksTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        if (Schema::hasTable('opportunities_links')) {
            return;
        }

        Schema::create('opportunities_links', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('opportunities_id')->unsigned()->index();
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
        if (! Schema::hasTable('opportunities_links')) {
            return;
        }

        Schema::drop('opportunities_links');
    }
}
