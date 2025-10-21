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
        Schema::table('zones_urbaines', function (Blueprint $table) {
            $table->text('description')->nullable()->after('nom');
            $table->decimal('densite_habitation', 5, 2)->nullable()->after('superficie');
            $table->boolean('actif')->default(true)->after('nb_arbres_exist');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('zones_urbaines', function (Blueprint $table) {
            $table->dropColumn(['description', 'densite_habitation', 'actif']);
        });
    }
};
