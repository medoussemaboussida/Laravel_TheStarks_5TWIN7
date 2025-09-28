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
        Schema::create('rapport_besoins', function (Blueprint $table) {
            $table->id();
            $table->date('date_rapport');
            $table->text('description');
            $table->enum('priorite', ['faible', 'moyenne', 'élevée']);
            $table->decimal('cout_estime', 10, 2);
            $table->enum('statut', ['en attente', 'en cours', 'réalisé']);
            $table->foreignId('espace_vert_id')->constrained('espace_verts')->onDelete('cascade');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('rapport_besoins');
    }
};
