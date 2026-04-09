<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateMaterialSeriesContentsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        if (Schema::hasTable('material_series_contents')) {
            return;
        }

        Schema::create('material_series_contents', function (Blueprint $table) {
            $table->increments('id');

            $table->string('series_1_title')->nullable();
            $table->longText('series_1_description')->nullable();
            $table->string('series_1_title_ar')->nullable();
            $table->longText('series_1_description_ar')->nullable();

            $table->string('series_2_title')->nullable();
            $table->longText('series_2_description')->nullable();
            $table->string('series_2_title_ar')->nullable();
            $table->longText('series_2_description_ar')->nullable();
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
        if (! Schema::hasTable('material_series_contents')) {
            return;
        }

        Schema::drop('material_series_contents');
    }
}
