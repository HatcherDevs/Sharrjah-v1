<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateLandingElementsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        if (Schema::hasTable('landing_elements')) {
            return;
        }

        Schema::create('landing_elements', function (Blueprint $table) {
            $table->increments('id');
            $table->string('title')->nullable();
            $table->string('title_ar')->nullable();
            $table->tinyInteger('order')->nullable();
            $table->tinyInteger('is_main')->default(0);
            $table->tinyInteger('active')->default(1);
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
        if (! Schema::hasTable('landing_elements')) {
            return;
        }

        Schema::drop('landing_elements');
    }
}
