<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePageParentsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        if (Schema::hasTable('page_parents')) {
            return;
        }

        Schema::create('page_parents', function (Blueprint $table) {
            $table->integer('page_id')->unsigned()->index();
            $table->foreign('page_id')->references('id')->on('pages')->onDelete('cascade');
            $table->integer('page_parent_id')->unsigned()->index();
            $table->foreign('page_parent_id')->references('id')->on('pages')->onDelete('cascade');
            $table->tinyInteger('active')->default('1');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('page_parents');
    }
}
