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
        Schema::table('batiments', function (Blueprint $table) {
            $table->json('emission_data')->nullable()->after('type_zone_urbaine');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('batiments', function (Blueprint $table) {
            $table->dropColumn('emission_data');
        });
    }
};
