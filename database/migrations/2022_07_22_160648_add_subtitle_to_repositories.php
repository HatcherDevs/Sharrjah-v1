<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class AddSubtitleToRepositories extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        if (! Schema::hasTable('repositories')) {
            return;
        }

        Schema::table('repositories', function (Blueprint $table) {
            $table->string('subtitle')->nullable();
            $table->string('subtitle_ar')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        if (! Schema::hasTable('repositories')) {
            return;
        }

        Schema::table('repositories', function (Blueprint $table) {
            $table->dropColumn('subtitle');
            $table->dropColumn('subtitle_ar');
        });
    }
}
