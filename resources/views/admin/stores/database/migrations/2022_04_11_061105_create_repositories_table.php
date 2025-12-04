<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateRepositoriesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('repositories', function (Blueprint $table) {
            $table->increments('id');

            $table->string('order_by');
            $table->string('bacground');
            $table->string('title');
            $table->string('title_ar')->nullable();
            $table->string('slug')->unique();
            $table->text('image')->nullable();
            $table->text('video')->nullable();
            $table->longText('content')->nullable() ;
            $table->longText('content_ar')->nullable();
            $table->integer('repository_type_id')->unsigned()->index();
            $table->foreign('repository_type_id')->references('id')->on('repository_types')->onDelete('cascade');
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
        Schema::drop('repositories');
    }
}
