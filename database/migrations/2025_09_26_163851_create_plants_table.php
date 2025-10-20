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
    Schema::create('plants', function (Blueprint $table) {
        $table->id();
        $table->string('name'); // nom de la plante (ex: Olivier, Rose, Jasmin)
        $table->integer('age')->nullable(); // âge de la plante
        $table->string('location')->nullable(); // lieu où elle est plantée
        $table->foreignId('plant_type_id')->constrained('plant_types')->onDelete('cascade');
        $table->timestamps();
    });
}


    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('plants');
    }
};
