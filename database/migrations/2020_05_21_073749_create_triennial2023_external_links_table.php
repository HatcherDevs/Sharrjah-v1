<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateTriennial2023ExternalLinksTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        if (Schema::hasTable('triennial2023_external_links')) {
            return;
        }

        Schema::create('triennial2023_external_links', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('triennial2023_id')->unsigned()->index();
            $table->foreign('triennial2023_id')->references('id')->on('triennial2023s')->onDelete('cascade');
            $table->string('language');
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
        if (! Schema::hasTable('triennial2023_external_links')) {
            return;
        }

        Schema::drop('triennial2023_external_links');
    }
}
