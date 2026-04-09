<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateResearchBuildingsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        if (Schema::hasTable('research_buildings')) {
            return;
        }

        Schema::create('research_buildings', function (Blueprint $table) {
            $table->increments('id');
            $table->string('title');
            $table->string('title_ar')->nullable();
            $table->string('slug')->unique();
            $table->string('lat');
            $table->string('lng');
            $table->text('image')->nullable();
            $table->longText('content')->nullable();
            $table->longText('content_ar')->nullable();
            $table->string('year');
            $table->integer('research_type_id')->unsigned()->index();
            $table->foreign('research_type_id')->references('id')->on('research_types')->onDelete('cascade');
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
        if (! Schema::hasTable('research_buildings')) {
            return;
        }

        Schema::drop('research_buildings');
    }
}
