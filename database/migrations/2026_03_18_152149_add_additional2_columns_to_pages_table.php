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
        Schema::table('pages', function (Blueprint $table) {
            if (! Schema::hasColumn('pages', 'additional2_content_en')) {
                $table->longText('additional2_content_en')->nullable()->after('additional_content_ar_active');
            }
            if (! Schema::hasColumn('pages', 'additional2_content_ar')) {
                $table->longText('additional2_content_ar')->nullable()->after('additional2_content_en');
            }
            if (! Schema::hasColumn('pages', 'additional2_content_img')) {
                $table->longText('additional2_content_img')->nullable()->after('additional2_content_ar');
            }
        });
    }

    public function down(): void
    {
        if (! Schema::hasTable('pages')) {
            return;
        }

        Schema::table('pages', function (Blueprint $table) {
            $table->dropColumn(['additional2_content_en', 'additional2_content_ar', 'additional2_content_img']);
        });
    }
};
