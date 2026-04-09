<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreatePublicationExternalLinksTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        if (Schema::hasTable('publication_external_links')) {
            return;
        }

        Schema::create('publication_external_links', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('publication_id')->unsigned()->index();
            $table->foreign('publication_id')->references('id')->on('publications')->onDelete('cascade');
            $table->string('url');
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
        if (! Schema::hasTable('publication_external_links')) {
            return;
        }

        Schema::drop('publication_external_links');
    }
}
