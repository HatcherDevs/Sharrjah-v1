<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateResearchFeedbacksTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        if (Schema::hasTable('research_feedbacks')) {
            return;
        }

        Schema::create('research_feedbacks', function (Blueprint $table) {
            $table->increments('id');
            $table->string('email');
            $table->longText('message');
            $table->string('ip')->nullable();
            $table->integer('research_building_id')->unsigned()->index();
            $table->foreign('research_building_id')->references('id')->on('research_buildings')->onDelete('cascade');
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
        if (! Schema::hasTable('research_feedbacks')) {
            return;
        }

        Schema::drop('research_feedbacks');
    }
}
