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
        Schema::table('landing_elements', function (Blueprint $table) {
            $table->string('center_image')->nullable();
            $table->string('bottom_left_image')->nullable();
            $table->string('bottom_right_image')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('landing_elements', function (Blueprint $table) {
            $table->dropColumn(['center_image', 'bottom_left_image', 'bottom_right_image']);
        });
    }
};