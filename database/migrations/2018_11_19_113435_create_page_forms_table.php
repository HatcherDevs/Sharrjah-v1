<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreatePageFormsTable extends Migration
{
    /**
     * Run the migrations.
     *
    'formable_type',
    'formable_id',
    'form_id'
     * @return void
     */
    public function up()
    {
        if (Schema::hasTable('page_forms')) {
            return;
        }

        Schema::create('page_forms', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('formable_id')->unsigned()->index()->nullable();
            $table->string('formable_type')->nullable();
            $table->integer('form_id')->unsigned()->index();
            $table->foreign('form_id')->references('id')->on('forms')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        if (! Schema::hasTable('page_forms')) {
            return;
        }

        Schema::drop('page_forms');
    }
}
