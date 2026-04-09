<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateOpportunitiesExternalFilesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        if (Schema::hasTable('opportunities_external_files')) {
            return;
        }

        Schema::create('opportunities_external_files', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('opportunities_id')->unsigned()->index();
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
        if (! Schema::hasTable('opportunities_external_files')) {
            return;
        }

        Schema::drop('opportunities_external_files');
    }
}
