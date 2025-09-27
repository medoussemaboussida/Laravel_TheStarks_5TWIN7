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
        Schema::table('users', function (Blueprint $table) {
            $table->enum('role', ['citoyen', 'chef_projet', 'admin'])->default('citoyen');
            $table->string('telephone')->nullable();
            $table->text('adresse')->nullable();
            $table->date('date_naissance')->nullable();
            $table->enum('genre', ['homme', 'femme', 'autre'])->nullable();
            $table->boolean('notifications_email')->default(true);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn([
                'role',
                'telephone',
                'adresse',
                'date_naissance',
                'genre',
                'notifications_email'
            ]);
        });
    }
};
