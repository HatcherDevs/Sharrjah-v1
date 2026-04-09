<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class AddIsOpenToMaterials extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        if (! Schema::hasTable('materials')) {
            return;
        }

        Schema::table('materials', function (Blueprint $table) {
            $table->tinyInteger('is_open')->default(0);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        if (! Schema::hasTable('materials')) {
            return;
        }

        Schema::table('materials', function (Blueprint $table) {
            $table->dropColumn('is_open');
        });
    }
}
