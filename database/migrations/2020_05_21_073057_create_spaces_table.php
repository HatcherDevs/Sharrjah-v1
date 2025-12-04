<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateSpacesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('spaces', function (Blueprint $table) {
            $table->increments('id');
            $table->string('title')->nullable();
            $table->string('title_ar')->nullable();
            $table->string('excerpt')->nullable();
            $table->string('excerpt_ar')->nullable();
            $table->string('speaker')->nullable();
            $table->string('speaker_ar')->nullable();
            $table->string('series')->nullable();
            $table->string('series_ar')->nullable();
            $table->string('country')->nullable();
            $table->string('country_ar')->nullable();
            $table->string('slug')->nullable();
            $table->string('description')->nullable();
            $table->string('description_ar')->nullable();
            $table->date('publish_date')->nullable()->default(null);
            $table->text('content')->nullable();
            $table->text('content_ar')->nullable();
            $table->longText('additional_content_top')->nullable();
            $table->longText('additional_content_bottom')->nullable();
            $table->longText('audio_file');
            $table->tinyInteger('active')->default('1');
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
        Schema::drop('podcasts');
    }
}
