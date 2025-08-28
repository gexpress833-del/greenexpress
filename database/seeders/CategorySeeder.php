<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class CategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        \App\Models\Category::truncate();

        $categories = [
            ['name' => 'Entrée', 'description' => 'Petits plats pour commencer le repas.'],
            ['name' => 'Plat principal', 'description' => 'Les plats de résistance.'],
            ['name' => 'Dessert', 'description' => 'Douceurs pour finir le repas.'],
            ['name' => 'Boisson', 'description' => 'Rafraîchissements.'],
        ];

        foreach ($categories as $categoryData) {
            \App\Models\Category::create($categoryData);
        }
        
        $this->command->info('Catégories semées.');
    }
}
