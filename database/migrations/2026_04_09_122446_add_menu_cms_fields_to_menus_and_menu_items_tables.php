<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        if (Schema::hasTable('menus')) {
            Schema::table('menus', function (Blueprint $table) {
                if (! Schema::hasColumn('menus', 'name')) {
                    $table->string('name')->nullable()->unique();
                }
                if (! Schema::hasColumn('menus', 'title_en')) {
                    $table->string('title_en')->nullable();
                }
                if (! Schema::hasColumn('menus', 'title_ar')) {
                    $table->string('title_ar')->nullable();
                }
                if (! Schema::hasColumn('menus', 'href')) {
                    $table->string('href')->nullable();
                }
                if (! Schema::hasColumn('menus', 'order')) {
                    $table->integer('order')->default(0);
                }
                if (! Schema::hasColumn('menus', 'active')) {
                    $table->boolean('active')->default(1);
                }
            });
        }

        if (Schema::hasTable('menu_items')) {
            Schema::table('menu_items', function (Blueprint $table) {
                if (! Schema::hasColumn('menu_items', 'menu_id')) {
                    $table->unsignedBigInteger('menu_id')->nullable();
                }
                if (! Schema::hasColumn('menu_items', 'parent_id')) {
                    $table->unsignedBigInteger('parent_id')->nullable();
                }
                if (! Schema::hasColumn('menu_items', 'title_en')) {
                    $table->string('title_en')->nullable();
                }
                if (! Schema::hasColumn('menu_items', 'title_ar')) {
                    $table->string('title_ar')->nullable();
                }
                if (! Schema::hasColumn('menu_items', 'href')) {
                    $table->string('href')->nullable();
                }
                if (! Schema::hasColumn('menu_items', 'active')) {
                    $table->boolean('active')->default(1);
                }
                if (! Schema::hasColumn('menu_items', 'order')) {
                    $table->integer('order')->default(0);
                }
                if (! Schema::hasColumn('menu_items', 'has_sub_items')) {
                    $table->boolean('has_sub_items')->default(0);
                }
            });

        }
    }

    public function down(): void
    {
        if (Schema::hasTable('menu_items')) {
            Schema::table('menu_items', function (Blueprint $table) {
                $columns = ['menu_id', 'parent_id', 'title_en', 'title_ar', 'href', 'active', 'order', 'has_sub_items'];
                foreach ($columns as $column) {
                    if (Schema::hasColumn('menu_items', $column)) {
                        $table->dropColumn($column);
                    }
                }
            });
        }

        if (Schema::hasTable('menus')) {
            Schema::table('menus', function (Blueprint $table) {
                $columns = ['name', 'title_en', 'title_ar', 'href', 'order', 'active'];
                foreach ($columns as $column) {
                    if (Schema::hasColumn('menus', $column)) {
                        $table->dropColumn($column);
                    }
                }
            });
        }
    }
};
