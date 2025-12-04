<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateFormQuestionChoicesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('form_question_choices', function (Blueprint $table) {
            $table->increments('id');
            $table->string('value')->default('N/A')->nullable();
            $table->string('value_ar')->default('N/A')->nullable();
            $table->integer('form_question_id')->unsigned()->index();
            $table->foreign('form_question_id')->references('id')->on('form_questions')->onDelete('cascade');
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
        Schema::drop('form_question_choices');
    }
}
