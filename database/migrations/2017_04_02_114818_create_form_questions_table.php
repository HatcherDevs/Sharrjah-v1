<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateFormQuestionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        if (Schema::hasTable('form_questions')) {
            return;
        }

        Schema::create('form_questions', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('form_id')->unsigned()->index();
            $table->foreign('form_id')->references('id')->on('forms')->onDelete('cascade');
            $table->integer('form_question_type_id')->unsigned()->index();
            $table->foreign('form_question_type_id')->references('id')->on('form_question_types')->onDelete('cascade');
            $table->string('question')->nullable();
            $table->string('question_ar')->nullable();
            $table->tinyInteger('order');
            $table->tinyInteger('is_required');
            $table->tinyInteger('is_float');
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
        if (! Schema::hasTable('form_questions')) {
            return;
        }

        Schema::drop('form_questions');
    }
}
