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
        Schema::table('meals', function (Blueprint $table) {
            // Ajouter les nouvelles colonnes de prix
            $table->decimal('price_cdf', 10, 2)->after('price')->default(0);
            $table->decimal('price_usd', 8, 2)->after('price_cdf')->default(0);
            
            // Supprimer l'ancienne colonne price
            $table->dropColumn('price');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('meals', function (Blueprint $table) {
            // Recréer l'ancienne colonne price
            $table->decimal('price', 8, 2)->after('description');
            
            // Supprimer les nouvelles colonnes
            $table->dropColumn(['price_cdf', 'price_usd']);
        });
    }
};
