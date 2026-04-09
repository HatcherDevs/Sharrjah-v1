<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class AddUrlToSpaceExternalLinksTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        if (! Schema::hasTable('space_external_links')) {
            return;
        }

        if (! Schema::hasColumn('space_external_links', 'url')) {
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
        if (! Schema::hasTable('space_external_links')) {
            return;
        }

        if (Schema::hasColumn('space_external_links', 'url')) {
            Schema::table('space_external_links', function (Blueprint $table) {
                $table->dropColumn('url');
            });
        }
    }
}