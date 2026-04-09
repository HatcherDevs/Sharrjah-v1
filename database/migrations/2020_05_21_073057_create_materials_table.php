<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateMaterialsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        if (Schema::hasTable('materials')) {
            return;
        }

        Schema::create('materials', function (Blueprint $table) {
            $table->increments('id');
            $table->string('title')->nullable();
            $table->string('title_ar')->nullable();
            $table->string('excerpt')->nullable();
            $table->string('excerpt_ar')->nullable();
            $table->string('slug')->nullable();
            $table->string('description')->nullable();
            $table->string('description_ar')->nullable();
            $table->date('publish_date')->nullable()->default(null);
            $table->text('content')->nullable();
            $table->text('content_ar')->nullable();
            $table->longText('additional_content_top')->nullable();
            $table->longText('additional_content_bottom')->nullable();
            $table->longText('video_file');
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
        if (! Schema::hasTable('podcasts')) {
            return;
        }

        Schema::drop('podcasts');
    }
}
