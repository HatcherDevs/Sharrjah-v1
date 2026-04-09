<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateResearchContentsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        if (Schema::hasTable('research_contents')) {
            return;
        }

        Schema::create('research_contents', function (Blueprint $table) {
            $table->increments('id');
            $table->string('title');
            $table->string('title_ar')->nullable();
            $table->string('slug')->unique();
            $table->longText('content')->nullable();
            $table->longText('content_two')->nullable();
            $table->longText('content_ar')->nullable();
            $table->longText('content_ar_two')->nullable();
            $table->tinyInteger('is_hidden')->default(0);
            $table->string('background');
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
        if (! Schema::hasTable('research_contents')) {
            return;
        }

        Schema::drop('research_contents');
    }
}
