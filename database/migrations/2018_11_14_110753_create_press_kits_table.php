<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreatePressKitsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        if (Schema::hasTable('press_kits')) {
            return;
        }

        Schema::create('press_kits', function (Blueprint $table) {
            $table->increments('id');
            $table->string('username');
            $table->string('password');
            $table->string('title');
            $table->string('title_ar');
            $table->string('description');
            $table->string('description_ar');
            $table->string('slug');
            $table->string('token');
            $table->date('publish_date');
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
        if (! Schema::hasTable('press_kits')) {
            return;
        }

        Schema::drop('press_kits');
    }
}
