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
        Schema::create('espace_verts', function (Blueprint $table) {
            $table->id();
            $table->string('nom'); // Name of the green space
            $table->string('adresse'); // Address
            $table->float('superficie'); // Area in square meters, can adjust type if needed
            $table->enum('type', ['parc', 'jardin', 'toit vert', 'autre']); // Type of space
            $table->enum('etat', ['bon', 'moyen', 'mauvais']); // Condition
            $table->json('besoin_specifique')->nullable(); // Specific needs: plantation, arrosage, etc.
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('espace_verts');
    }
};
