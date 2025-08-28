<?php

namespace Database\Seeders;

use App\Models\Subscription;
use App\Models\User;
use Illuminate\Database\Seeder;

class SubscriptionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Récupérer un client existant pour l'assignation
        $client = User::where('role', 'client')->first();

        if ($client) {
            // Supprimer les anciens abonnements du client pour éviter les doublons
            $client->subscriptions()->delete();

            // Récupérer les plans d'abonnement à jour
            $basicWeeklyPlan = \App\Models\SubscriptionPlan::where('category_type', 'basic')->where('duration_type', 'weekly')->first();
            $basicMonthlyPlan = \App\Models\SubscriptionPlan::where('category_type', 'basic')->where('duration_type', 'monthly')->first();
            $professionalWeeklyPlan = \App\Models\SubscriptionPlan::where('category_type', 'professional')->where('duration_type', 'weekly')->first();
            $professionalMonthlyPlan = \App\Models\SubscriptionPlan::where('category_type', 'professional')->where('duration_type', 'monthly')->first();
            $premiumWeeklyPlan = \App\Models\SubscriptionPlan::where('category_type', 'premium')->where('duration_type', 'weekly')->first();
            $premiumMonthlyPlan = \App\Models\SubscriptionPlan::where('category_type', 'premium')->where('duration_type', 'monthly')->first();

            if ($basicWeeklyPlan) {
                Subscription::create([
                    'user_id' => $client->id,
                    'name' => $basicWeeklyPlan->name,
                    'category_type' => $basicWeeklyPlan->category_type,
                    'duration_type' => $basicWeeklyPlan->duration_type,
                    'unit_price_per_meal_cdf' => $basicWeeklyPlan->unit_price_per_meal_cdf,
                    'package_price_cdf' => $basicWeeklyPlan->package_price_cdf,
                    'meal_count' => $basicWeeklyPlan->meal_count,
                    'plan_description' => $basicWeeklyPlan->description,
                    'start_date' => now(),
                    'end_date' => now()->addWeeks(1),
                    'status' => 'active',
                ]);
            }

            if ($basicMonthlyPlan) {
                Subscription::create([
                    'user_id' => $client->id,
                    'name' => $basicMonthlyPlan->name,
                    'category_type' => $basicMonthlyPlan->category_type,
                    'duration_type' => $basicMonthlyPlan->duration_type,
                    'unit_price_per_meal_cdf' => $basicMonthlyPlan->unit_price_per_meal_cdf,
                    'package_price_cdf' => $basicMonthlyPlan->package_price_cdf,
                    'meal_count' => $basicMonthlyPlan->meal_count,
                    'plan_description' => $basicMonthlyPlan->description,
                    'start_date' => now(),
                    'end_date' => now()->addMonths(1),
                    'status' => 'active',
                ]);
            }

            if ($professionalWeeklyPlan) {
                Subscription::create([
                    'user_id' => $client->id,
                    'name' => $professionalWeeklyPlan->name,
                    'category_type' => $professionalWeeklyPlan->category_type,
                    'duration_type' => $professionalWeeklyPlan->duration_type,
                    'unit_price_per_meal_cdf' => $professionalWeeklyPlan->unit_price_per_meal_cdf,
                    'package_price_cdf' => $professionalWeeklyPlan->package_price_cdf,
                    'meal_count' => $professionalWeeklyPlan->meal_count,
                    'plan_description' => $professionalWeeklyPlan->description,
                    'start_date' => now(),
                    'end_date' => now()->addWeeks(1),
                    'status' => 'active',
                ]);
            }

            if ($professionalMonthlyPlan) {
                Subscription::create([
                    'user_id' => $client->id,
                    'name' => $professionalMonthlyPlan->name,
                    'category_type' => $professionalMonthlyPlan->category_type,
                    'duration_type' => $professionalMonthlyPlan->duration_type,
                    'unit_price_per_meal_cdf' => $professionalMonthlyPlan->unit_price_per_meal_cdf,
                    'package_price_cdf' => $professionalMonthlyPlan->package_price_cdf,
                    'meal_count' => $professionalMonthlyPlan->meal_count,
                    'plan_description' => $professionalMonthlyPlan->description,
                    'start_date' => now(),
                    'end_date' => now()->addMonths(1),
                    'status' => 'active',
                ]);
            }

            if ($premiumWeeklyPlan) {
                Subscription::create([
                    'user_id' => $client->id,
                    'name' => $premiumWeeklyPlan->name,
                    'category_type' => $premiumWeeklyPlan->category_type,
                    'duration_type' => $premiumWeeklyPlan->duration_type,
                    'unit_price_per_meal_cdf' => $premiumWeeklyPlan->unit_price_per_meal_cdf,
                    'package_price_cdf' => $premiumWeeklyPlan->package_price_cdf,
                    'meal_count' => $premiumWeeklyPlan->meal_count,
                    'plan_description' => $premiumWeeklyPlan->description,
                    'start_date' => now(),
                    'end_date' => now()->addWeeks(1),
                    'status' => 'active',
                ]);
            }

            if ($premiumMonthlyPlan) {
                Subscription::create([
                    'user_id' => $client->id,
                    'name' => $premiumMonthlyPlan->name,
                    'category_type' => $premiumMonthlyPlan->category_type,
                    'duration_type' => $premiumMonthlyPlan->duration_type,
                    'unit_price_per_meal_cdf' => $premiumMonthlyPlan->unit_price_per_meal_cdf,
                    'package_price_cdf' => $premiumMonthlyPlan->package_price_cdf,
                    'meal_count' => $premiumMonthlyPlan->meal_count,
                    'plan_description' => $premiumMonthlyPlan->description,
                    'start_date' => now(),
                    'end_date' => now()->addMonths(1),
                    'status' => 'active',
                ]);
            }
        }

        $this->command->info('Abonnements semés.');
    }
}
