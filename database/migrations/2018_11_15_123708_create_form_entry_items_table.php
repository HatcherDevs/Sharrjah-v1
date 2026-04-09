<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateFormEntryItemsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        if (Schema::hasTable('form_entry_items')) {
            return;
        }

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
        if (! Schema::hasTable('form_entry_items')) {
            return;
        }

        Schema::drop('form_entry_items');
    }
}
