<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class AddMainToTourImageSlides extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        if (! Schema::hasTable('tour_image_slides')) {
            return;
        }

        Schema::table('tour_image_slides', function (Blueprint $table) {
            $table->tinyInteger('is_main')->default(0);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        if (! Schema::hasTable('tour_image_slides')) {
            return;
        }

        Schema::table('tour_image_slides', function (Blueprint $table) {
            $table->dropColumn('is_main');
        });
    }
}
