<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateUploadsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        if (Schema::hasTable('uploads')) {
            return;
        }

        Schema::create('uploads', function (Blueprint $table) {
            $table->increments('id');
            $table->string('path');
            $table->string('original_name');
            $table->string('caption')->nullable();
            $table->string('caption_ar')->nullable();
            $table->string('file_name');
            $table->string('mime_type');
            $table->string('template');
            $table->integer('uploadable_id')->unsigned()->index()->nullable();
            $table->string('uploadable_type')->nullable();
            $table->tinyInteger('status');
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
        if (! Schema::hasTable('uploads')) {
            return;
        }

        Schema::drop('uploads');
    }
}
