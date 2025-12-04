<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateButtonLinksTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('button_links', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('linkable_id')->unsigned()->index()->nullable();
            $table->string('linkable_type')->nullable();
            $table->string('title')->nullable();
            $table->string('title_ar')->nullable();
            $table->string('value')->nullable();
            $table->string('value_ar')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('button_links');
    }
}
