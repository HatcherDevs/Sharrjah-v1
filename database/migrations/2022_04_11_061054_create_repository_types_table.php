<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateRepositoryTypesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        if (Schema::hasTable('repository_types')) {
            return;
        }

        Schema::create('repository_types', function (Blueprint $table) {
            $table->increments('id');
            $table->string('title');
            $table->string('title_ar')->nullable();
            $table->longText('content')->nullable();
            $table->longText('content_ar')->nullable();
            $table->string('slug')->unique();
            $table->tinyInteger('is_video')->default(1);
            $table->string('is_hidden');
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
        if (! Schema::hasTable('repository_types')) {
            return;
        }

        Schema::drop('repository_types');
    }
}
