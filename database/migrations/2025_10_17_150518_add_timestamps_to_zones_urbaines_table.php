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
            if (!Schema::hasColumn('zones_urbaines', 'nom')) {
                $table->string('nom');
            }
            if (!Schema::hasColumn('zones_urbaines', 'superficie')) {
                $table->decimal('superficie', 10, 2);
            }
            if (!Schema::hasColumn('zones_urbaines', 'population')) {
                $table->integer('population');
            }
            if (!Schema::hasColumn('zones_urbaines', 'created_at')) {
                $table->timestamps();
            }
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('zones_urbaines', function (Blueprint $table) {
            $table->dropColumn(['nom', 'superficie', 'population']);
            $table->dropTimestamps();
        });
    }
};
