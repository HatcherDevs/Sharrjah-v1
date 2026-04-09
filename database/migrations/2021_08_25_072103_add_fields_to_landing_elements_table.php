<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class AddFieldsToLandingElementsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        if (! Schema::hasTable('landing_elements')) {
            return;
        }

        Schema::table('landing_elements', function (Blueprint $table) {
            $table->string('background_windows')->before('created_at')->nullable();
            $table->string('background_macos')->before('created_at')->nullable();
            $table->tinyInteger('white_logos')->before('created_at')->default(0);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        if (! Schema::hasTable('landing_elements')) {
            return;
        }

        Schema::table('landing_elements', function (Blueprint $table) {
            $table->dropColumn('background_windows');
            $table->dropColumn('background_macos');
            $table->dropColumn('white_logos');
        });
    }
}
