<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePublicationsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('publications', function (Blueprint $table) {
            //        'title',
            //        'title_ar',
            //        'author',
            //        'author_ar',
            //        'publication',
            //        'publication_ar',
            //        'slug',
            //        'link',
            //        'link_ar',
            //        'description',
            //        'description_ar',
            //        'publish_date',
            //        'content',
            //        'content_ar',
            //        'content_additional',
            //        'additional_content_top',
            //        'additional_content_bottom',
            //        'is_external',
            //        'active',

            $table->increments('id');
            $table->string('title')->nullable();
            $table->string('title_ar')->nullable();
            $table->string('excerpt')->nullable();
            $table->string('excerpt_ar')->nullable();
            $table->string('author')->nullable();
            $table->string('author_ar')->nullable();
            $table->string('publication')->nullable();
            $table->string('publication_ar')->nullable();
            $table->string('slug')->nullable();
            $table->string('description')->nullable();
            $table->string('description_ar')->nullable();
            $table->date('publish_date')->nullable()->default(null);
            $table->text('content')->nullable();
            $table->text('content_ar')->nullable();
            $table->longText('additional_content_top')->nullable();
            $table->longText('additional_content_bottom')->nullable();
            $table->tinyInteger('active')->default('1');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('publications');
    }
}
