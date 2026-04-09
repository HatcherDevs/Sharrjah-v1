<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateButtonLinksTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        if (Schema::hasTable('button_links')) {
            return;
        }

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
        if (! Schema::hasTable('button_links')) {
            return;
        }

        Schema::drop('button_links');
    }
}
