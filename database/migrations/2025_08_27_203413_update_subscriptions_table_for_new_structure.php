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
        Schema::table('subscriptions', function (Blueprint $table) {
            // Renommer les colonnes existantes
            $table->renameColumn('type', 'category_type');
            $table->renameColumn('normal_price_cdf', 'unit_price_per_meal_cdf');
            $table->renameColumn('subscription_price_cdf', 'package_price_cdf');
            
            // Ajouter de nouvelles colonnes
            $table->enum('duration_type', ['weekly', 'monthly'])->after('category_type');
            $table->text('plan_description')->nullable()->after('meal_count');

            // Supprimer l'ancienne colonne 'benefits' si elle existe
            // $table->dropColumn('benefits'); // Ceci sera fait dans un second temps après avoir rempli plan_description avec les données de benefits
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('subscriptions', function (Blueprint $table) {
            // Annuler les renommages
            $table->renameColumn('category_type', 'type');
            $table->renameColumn('unit_price_per_meal_cdf', 'normal_price_cdf');
            $table->renameColumn('package_price_cdf', 'subscription_price_cdf');

            // Supprimer les colonnes ajoutées
            $table->dropColumn('duration_type');
            $table->dropColumn('plan_description');

            // Recréer l'ancienne colonne 'benefits' si nécessaire
            // $table->text('benefits')->nullable()->after('meal_count');
        });
    }
};
