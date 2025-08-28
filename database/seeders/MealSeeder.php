<?php

namespace Database\Seeders;

use App\Models\Meal;
use Illuminate\Database\Seeder;
use App\Models\Category; // Ajouter l'import du modèle Category

class MealSeeder extends Seeder
{
    public function run(): void
    {
        Meal::truncate(); // Vider la table avant de reseeder

        // Récupérer les IDs des catégories
        $entreeCategory = Category::where('name', 'Entrée')->first()->id ?? null;
        $platCategory = Category::where('name', 'Plat principal')->first()->id ?? null;
        $dessertCategory = Category::where('name', 'Dessert')->first()->id ?? null;
        $boissonCategory = Category::where('name', 'Boisson')->first()->id ?? null;

        // Entrées
        Meal::create([
            'name' => 'Salade César',
            'description' => 'Salade romaine, parmesan, croûtons, sauce césar',
            'price_cdf' => 22950, // 8.50 USD * 2700
            'price_usd' => 8.50,
            'image' => 'meals/salade-cesar.jpg',
            'category_id' => $entreeCategory, // Utiliser category_id
            'is_available' => true,
        ]);

        Meal::create([
            'name' => 'Soupe à l\'oignon',
            'description' => 'Soupe traditionnelle française avec fromage gratiné',
            'price_cdf' => 18900, // 7.00 USD * 2700
            'price_usd' => 7.00,
            'image' => 'meals/soupe-oignon.jpg',
            'category_id' => $entreeCategory, // Utiliser category_id
            'is_available' => true,
        ]);

        Meal::create([
            'name' => 'Terrine de campagne',
            'description' => 'Terrine maison avec cornichons et pain de campagne',
            'price_cdf' => 24300, // 9.00 USD * 2700
            'price_usd' => 9.00,
            'image' => 'meals/terrine-campagne.jpg',
            'category_id' => $entreeCategory, // Utiliser category_id
            'is_available' => true,
        ]);

        // Plats
        Meal::create([
            'name' => 'Poulet rôti aux herbes',
            'description' => 'Poulet fermier rôti avec herbes de Provence et légumes',
            'price_cdf' => 44550, // 16.50 USD * 2700
            'price_usd' => 16.50,
            'image' => 'meals/poulet-roti.jpg',
            'category_id' => $platCategory, // Utiliser category_id
            'is_available' => true,
        ]);

        Meal::create([
            'name' => 'Saumon grillé',
            'description' => 'Saumon d\'Écosse grillé avec riz sauvage et légumes',
            'price_cdf' => 48600, // 18.00 USD * 2700
            'price_usd' => 18.00,
            'image' => 'meals/saumon-grille.jpg',
            'category_id' => $platCategory, // Utiliser category_id
            'is_available' => true,
        ]);

        Meal::create([
            'name' => 'Steak frites',
            'description' => 'Steak de bœuf, frites maison, salade verte',
            'price_cdf' => 52650, // 19.50 USD * 2700
            'price_usd' => 19.50,
            'image' => 'meals/steak-frites.jpg',
            'category_id' => $platCategory, // Utiliser category_id
            'is_available' => true,
        ]);

        Meal::create([
            'name' => 'Risotto aux champignons',
            'description' => 'Risotto crémeux aux champignons de Paris',
            'price_cdf' => 37800, // 14.00 USD * 2700
            'price_usd' => 14.00,
            'image' => 'meals/risotto-champignons.jpg',
            'category_id' => $platCategory, // Utiliser category_id
            'is_available' => true,
        ]);

        Meal::create([
            'name' => 'Lasagnes bolognaise',
            'description' => 'Lasagnes traditionnelles à la bolognaise',
            'price_cdf' => 41850, // 15.50 USD * 2700
            'price_usd' => 15.50,
            'image' => 'meals/lasagnes-bolognaise.jpg',
            'category_id' => $platCategory, // Utiliser category_id
            'is_available' => true,
        ]);

        // Desserts
        Meal::create([
            'name' => 'Crème brûlée',
            'description' => 'Crème brûlée à la vanille de Madagascar',
            'price_cdf' => 17550, // 6.50 USD * 2700
            'price_usd' => 6.50,
            'image' => 'meals/creme-brulee.jpg',
            'category_id' => $dessertCategory, // Utiliser category_id
            'is_available' => true,
        ]);

        Meal::create([
            'name' => 'Tarte Tatin',
            'description' => 'Tarte Tatin traditionnelle aux pommes',
            'price_cdf' => 18900, // 7.00 USD * 2700
            'price_usd' => 7.00,
            'image' => 'meals/tarte-tatin.jpg',
            'category_id' => $dessertCategory, // Utiliser category_id
            'is_available' => true,
        ]);

        Meal::create([
            'name' => 'Mousse au chocolat',
            'description' => 'Mousse au chocolat noir 70%',
            'price_cdf' => 16200, // 6.00 USD * 2700
            'price_usd' => 6.00,
            'image' => 'meals/mousse-chocolat.jpg',
            'category_id' => $dessertCategory, // Utiliser category_id
            'is_available' => true,
        ]);

        // Boissons
        Meal::create([
            'name' => 'Eau minérale',
            'description' => 'Eau minérale naturelle 50cl',
            'price_cdf' => 6750, // 2.50 USD * 2700
            'price_usd' => 2.50,
            'image' => 'meals/eau-minerale.jpg',
            'category_id' => $boissonCategory, // Utiliser category_id
            'is_available' => true,
        ]);

        Meal::create([
            'name' => 'Jus d\'orange frais',
            'description' => 'Jus d\'orange pressé 25cl',
            'price_cdf' => 9450, // 3.50 USD * 2700
            'price_usd' => 3.50,
            'image' => 'meals/jus-orange.jpg',
            'category_id' => $boissonCategory, // Utiliser category_id
            'is_available' => true,
        ]);

        Meal::create([
            'name' => 'Café expresso',
            'description' => 'Café expresso italien',
            'price_cdf' => 5400, // 2.00 USD * 2700
            'price_usd' => 2.00,
            'image' => 'meals/cafe-expresso.jpg',
            'category_id' => $boissonCategory, // Utiliser category_id
            'is_available' => true,
        ]);

        Meal::create([
            'name' => 'Thé vert',
            'description' => 'Thé vert bio avec citron',
            'price_cdf' => 6750, // 2.50 USD * 2700
            'price_usd' => 2.50,
            'image' => 'meals/the-vert.jpg',
            'category_id' => $boissonCategory, // Utiliser category_id
            'is_available' => true,
        ]);
    }
}
