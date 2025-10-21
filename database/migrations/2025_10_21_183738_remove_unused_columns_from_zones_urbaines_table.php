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
            $table->dropColumn([
                'population',
                'nb_arbres_exist',
                'niveau_pollution',
                'superficie',
                'description',
                'densite_habitation',
                'actif'
            ]);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('zones_urbaines', function (Blueprint $table) {
            $table->integer('population')->default(0)->after('nom');
            $table->integer('nb_arbres_exist')->default(0)->after('population');
            $table->decimal('niveau_pollution', 5, 2)->default(0)->after('nb_arbres_exist');
            $table->decimal('superficie', 10, 2)->default(0)->after('niveau_pollution');
            $table->text('description')->nullable()->after('superficie');
            $table->decimal('densite_habitation', 5, 2)->nullable()->after('description');
            $table->boolean('actif')->default(true)->after('densite_habitation');
        });
    }
};
