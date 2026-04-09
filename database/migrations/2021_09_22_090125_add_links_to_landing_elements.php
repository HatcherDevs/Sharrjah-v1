<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class AddLinksToLandingElements extends Migration
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
            $table->string('link')->before('created_at')->nullable();
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
            $table->dropColumn('link');
        });
    }
}
