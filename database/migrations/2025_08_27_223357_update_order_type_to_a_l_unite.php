<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB; // Added this import for DB facade

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        // D'abord, changer la définition de la colonne pour qu'elle puisse contenir 'a_l_unite'
        Schema::table('orders', function (Blueprint $table) {
            $table->string('type', 20)->change(); // Augmenter la taille à 20 caractères
        });

        // Ensuite, mettre à jour les valeurs existantes dans la base de données
        DB::table('orders')
            ->where('type', 'single')
            ->update(['type' => 'a_l_unite']);
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        // Revenir aux valeurs précédentes dans la base de données
        DB::table('orders')
            ->where('type', 'a_l_unite')
            ->update(['type' => 'single']);

        // Revenir à la définition originale de la colonne (si nécessaire, ou laisser en string)
        Schema::table('orders', function (Blueprint $table) {
            $table->string('type', 6)->change(); // Revenir à la taille originale si c'est le cas, ou 20 si c'est une chaîne générique
        });
    }
};
