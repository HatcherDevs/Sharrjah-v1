<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddUrlToSpaceExternalLinksTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        if (!Schema::hasColumn('space_external_links', 'url')) {
            Schema::table('space_external_links', function (Blueprint $table) {
                $table->string('url')->after('language')->nullable();
            });
        }
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        if (Schema::hasColumn('space_external_links', 'url')) {
            Schema::table('space_external_links', function (Blueprint $table) {
                $table->dropColumn('url');
            });
        }
    }
}