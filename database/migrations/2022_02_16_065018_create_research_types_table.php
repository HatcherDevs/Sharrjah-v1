<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateResearchTypesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        if (Schema::hasTable('research_types')) {
            return;
        }

        Schema::create('research_types', function (Blueprint $table) {
            $table->increments('id');
            $table->string('title');
            $table->string('title_ar')->nullable();
            $table->longText('content')->nullable();
            $table->longText('content_ar')->nullable();
            $table->boolean('content_is_hidden')->nullable();

            $table->string('slug')->unique();
            $table->string('color');

            $table->longText('pre-1960')->nullable();
            $table->longText('pre-1960_ar')->nullable();
            $table->boolean('pre-1960_is_hidden')->nullable();

            $table->longText('1960-1980')->nullable();
            $table->longText('1960-1980_ar')->nullable();
            $table->boolean('1960-1980_is_hidden')->nullable();

            $table->longText('1981-2000')->nullable();
            $table->longText('1981-2000_ar')->nullable();
            $table->boolean('1981-2000_is_hidden')->nullable();

            $table->longText('2001-2020')->nullable();
            $table->longText('2001-2020_ar')->nullable();
            $table->boolean('2001-2020_is_hidden')->nullable();

            $table->longText('post-2020')->nullable();
            $table->longText('post-2020_ar')->nullable();
            $table->boolean('post-2020_is_hidden')->nullable();

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
        if (! Schema::hasTable('research_types')) {
            return;
        }

        Schema::drop('research_types');
    }
}
