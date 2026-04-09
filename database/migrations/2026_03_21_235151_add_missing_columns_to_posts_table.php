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
        if (! Schema::hasTable('posts')) {
            return;
        }

        Schema::table('posts', function (Blueprint $table) {
            $table->string('link')->nullable()->after('title_ar');
            $table->string('link_ar')->nullable()->after('link');
            $table->tinyInteger('is_external')->default(0)->after('active');
            $table->text('content_additional')->nullable()->after('content_ar');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        if (! Schema::hasTable('posts')) {
            return;
        }

        Schema::table('posts', function (Blueprint $table) {
            $table->dropColumn(['link', 'link_ar', 'is_external', 'content_additional']);
        });
    }
};
