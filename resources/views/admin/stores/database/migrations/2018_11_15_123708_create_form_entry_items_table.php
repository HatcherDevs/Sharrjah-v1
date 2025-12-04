<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateFormEntryItemsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('form_entry_items', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('form_question_id')->unsigned()->index();
            $table->foreign('form_question_id')->references('id')->on('form_questions')->onDelete('cascade');
            $table->integer('form_entry_id')->unsigned()->index();
            $table->foreign('form_entry_id')->references('id')->on('form_entries')->onDelete('cascade');
            $table->string('value')->nullable();
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
        Schema::drop('form_entry_items');
    }
}
