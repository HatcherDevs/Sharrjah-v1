<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateFormsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        if (Schema::hasTable('forms')) {
            return;
        }

        Schema::create('forms', function (Blueprint $table) {
            $table->increments('id');
            $table->string('title');
            $table->string('title_ar');
            $table->string('slug')->unique();
            $table->text('description')->nullable();
            $table->text('description_ar')->nullable();
            $table->tinyInteger('is_active')->default(1);
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
        if (! Schema::hasTable('forms')) {
            return;
        }

        Schema::drop('forms');
    }
}
