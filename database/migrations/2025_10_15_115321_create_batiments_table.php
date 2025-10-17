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
        if (!Schema::hasTable('batiments')) {
            Schema::create('batiments', function (Blueprint $table) {
                $table->id();
                $table->enum('type_batiment', ['Maison', 'Usine']);
                $table->string('adresse');
                $table->decimal('emissionCO2', 10, 2)->default(0);
                $table->integer('nbHabitants')->nullable();
                $table->integer('nbEmployes')->nullable();
                $table->string('typeIndustrie')->nullable();
                $table->decimal('pourcentageRenouvelable', 5, 2)->default(0);
                $table->decimal('emissionReelle', 10, 2)->default(0);
                $table->foreignId('zone_id')->nullable()->constrained('zones_urbaines')->onDelete('set null');
                $table->timestamps();
            });
        } else {
            Schema::table('batiments', function (Blueprint $table) {
                if (!Schema::hasColumn('batiments', 'created_at')) {
                    $table->timestamps();
                }
            });
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('batiments');
    }
};
