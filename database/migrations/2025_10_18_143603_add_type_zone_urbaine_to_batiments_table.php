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
            $table->enum('type_zone_urbaine', ['zone_industrielle', 'quartier_residentiel', 'centre_ville'])->nullable()->after('etat');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('batiments', function (Blueprint $table) {
            $table->dropColumn('type_zone_urbaine');
        });
    }
};
