<?php

namespace Database\Seeders;

use App\Models\SubscriptionPlan;
use Illuminate\Database\Seeder;

class SubscriptionPlanSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Suppression des anciens plans pour éviter les doublons et les conflits de types
        SubscriptionPlan::truncate();

        // Formule SÉCULIER / BASIC - Hebdomadaire
        SubscriptionPlan::create([
            'name' => 'Formule Séculier/Basic - Hebdomadaire',
            'category_type' => 'basic',
            'duration_type' => 'weekly',
            'unit_price_per_meal_cdf' => 6000,
            'package_price_cdf' => 27000,
            'meal_count' => 5,
            'benefits' => 'Prix réduit, adapté aux besoins quotidiens',
            'description' => 'Lundi: Sandwich au saucisse + salade verte<br/>Mardi: Frites + poulet rôtis<br/>Mercredi: Burger local<br/>Jeudi: Riz sauté + omelette<br/>Vendredi: Frites + poulet rôtis + Salade fruits',
        ]);

        // Formule SÉCULIER / BASIC - Mensuel
        SubscriptionPlan::create([
            'name' => 'Formule Séculier/Basic - Mensuel',
            'category_type' => 'basic',
            'duration_type' => 'monthly',
            'unit_price_per_meal_cdf' => 6000,
            'package_price_cdf' => 108000,
            'meal_count' => 20,
            'benefits' => 'Fidélisation + repas réguliers avec 10% de remise mensuelle.',
            'description' => 'Lundi: Sandwich au saucisse + salade verte<br/>Mardi: Frites + poulet rôtis<br/>Mercredi: Burger local<br/>Jeudi: Riz sauté + omelette<br/>Vendredi: Frites + poulet rôtis + Salade fruits',
        ]);

        // Formule PROFESSIONNEL - Hebdomadaire
        SubscriptionPlan::create([
            'name' => 'Formule Professionnel - Hebdomadaire',
            'category_type' => 'professional',
            'duration_type' => 'weekly',
            'unit_price_per_meal_cdf' => 9000,
            'package_price_cdf' => 40000,
            'meal_count' => 5,
            'benefits' => 'Repas équilibrés livrés à domicile ou au bureau',
            'description' => 'Lundi: Pommes de terre sautées + œuf + salade<br/>Mardi: Riz jaune + viande en sauce + plantain<br/>Mercredi: Fufu + pondu + poisson frit<br/>Jeudi: Riz blanc + poulet grillé + légumes sautés<br/>Vendredi: Frites + Poulet mayo rôtis + Salade végétarienne',
        ]);

        // Formule PROFESSIONNEL - Mensuel
        SubscriptionPlan::create([
            'name' => 'Formule Professionnel - Mensuel',
            'category_type' => 'professional',
            'duration_type' => 'monthly',
            'unit_price_per_meal_cdf' => 9000,
            'package_price_cdf' => 162000,
            'meal_count' => 20,
            'benefits' => 'Confort et gain de temps avec 10% de remise mensuelle.',
            'description' => 'Lundi: Pommes de terre sautées + œuf + salade<br/>Mardi: Riz jaune + viande en sauce + plantain<br/>Mercredi: Fufu + pondu + poisson frit<br/>Jeudi: Riz blanc + poulet grillé + légumes sautés<br/>Vendredi: Frites + Poulet mayo rôtis + Salade végétarienne',
        ]);

        // Formule PREMIUM ENTREPRISE - Hebdomadaire
        SubscriptionPlan::create([
            'name' => 'Formule Premium Entreprise - Hebdomadaire',
            'category_type' => 'premium',
            'duration_type' => 'weekly',
            'unit_price_per_meal_cdf' => 13000,
            'package_price_cdf' => 60000,
            'meal_count' => 5,
            'benefits' => 'Pour gros consommateurs, menus variés sur commande du client',
            'description' => 'Lundi: Tilapia grillé + riz parfumé + légumes<br/>Mardi: Brochettes de bœuf + plantain frit + sauce spéciale<br/>Mercredi: Spaghetti fruits de mer + salade mixte<br/>Jeudi: Poulet braisé + pommes sautées + salade composée<br/>Vendredi: Frites + Poulet Rôtis + Salade Mixte',
        ]);

        // Formule PREMIUM ENTREPRISE - Mensuel
        SubscriptionPlan::create([
            'name' => 'Formule Premium Entreprise - Mensuel',
            'category_type' => 'premium',
            'duration_type' => 'monthly',
            'unit_price_per_meal_cdf' => 13000,
            'package_price_cdf' => 234000,
            'meal_count' => 20,
            'benefits' => 'Pour gros consommateurs, menus variés sur commande du client avec 10% de remise mensuelle.',
            'description' => 'Lundi: Tilapia grillé + riz parfumé + légumes<br/>Mardi: Brochettes de bœuf + plantain frit + sauce spéciale<br/>Mercredi: Spaghetti fruits de mer + salade mixte<br/>Jeudi: Poulet braisé + pommes sautées + salade composée<br/>Vendredi: Frites + Poulet Rôtis + Salade Mixte',
        ]);

        $this->command->info('Formules d\'abonnement semées.');
    }
}
