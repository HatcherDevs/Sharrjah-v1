<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        if (! Schema::hasTable('landing_elements') || Schema::hasColumn('landing_elements', 'display_on')) {
            return;
        }

        Schema::table('landing_elements', function (Blueprint $table) {
            $table->string('display_on')->default('both')->after('link');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        if (! Schema::hasTable('landing_elements') || ! Schema::hasColumn('landing_elements', 'display_on')) {
            return;
        }

        Schema::table('landing_elements', function (Blueprint $table) {
            $table->dropColumn('display_on');
        });
    }
};