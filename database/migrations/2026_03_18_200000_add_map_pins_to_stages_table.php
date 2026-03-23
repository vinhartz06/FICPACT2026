<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('stages', function (Blueprint $table) {
            $table->decimal('map_pin_x', 5, 2)->nullable()->after('is_boss_stage');
            $table->decimal('map_pin_y', 5, 2)->nullable()->after('map_pin_x');
        });
    }

    public function down(): void
    {
        Schema::table('stages', function (Blueprint $table) {
            $table->dropColumn(['map_pin_x', 'map_pin_y']);
        });
    }
};
