<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        if (! Schema::hasTable('menus')) {
            return;
        }

        if (Schema::hasColumn('menus', 'menu_type')) {
            return;
        }

        Schema::table('menus', function (Blueprint $table) {
            $table->string('menu_type')->default('desktop')->after('name');
        });
    }

    public function down(): void
    {
        if (! Schema::hasTable('menus')) {
            return;
        }

        if (! Schema::hasColumn('menus', 'menu_type')) {
            return;
        }

        Schema::table('menus', function (Blueprint $table) {
            $table->dropColumn('menu_type');
        });
    }
};