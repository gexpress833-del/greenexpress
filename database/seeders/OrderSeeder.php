<?php

namespace Database\Seeders;

use App\Models\Order;
use App\Models\OrderItem;
use App\Models\User;
use App\Models\Meal;
use App\Models\Subscription;
use Illuminate\Database\Seeder;

class OrderSeeder extends Seeder
{
    public function run(): void
    {
        $clients = User::clients()->get();
        $drivers = User::drivers()->get();
        $meals = Meal::all();
        
        // Créer des commandes pour chaque client
        foreach ($clients as $client) {
            // S'assurer que l'utilisateur a une adresse
            $deliveryAddress = $client->address ?: '123 Rue de la Santé, 75001 Paris';
            
            // Commande simple en attente
            $order1 = Order::create([
                'user_id' => $client->id,
                'type' => 'single',
                'total_amount' => 0,
                'status' => 'pending',
                'delivery_address' => $deliveryAddress,
                'notes' => 'Livraison avant 12h si possible',
            ]);
            
            // Ajouter des articles à la commande
            $total1 = 0;
            for ($i = 0; $i < rand(1, 3); $i++) {
                $meal = $meals->random();
                $quantity = rand(1, 2);
                $itemTotalPrice = $meal->price_usd * $quantity; // Utiliser price_usd
                $total1 += $itemTotalPrice;
                
                OrderItem::create([
                    'order_id' => $order1->id,
                    'meal_id' => $meal->id,
                    'quantity' => $quantity,
                    'unit_price' => $meal->price_usd, // Utiliser price_usd
                    'total_price' => $itemTotalPrice,
                ]);
            }
            $order1->update(['total_amount' => $total1]);
            
            // Commande avec abonnement validée
            $subscription = Subscription::where('user_id', $client->id)->active()->first();
            if ($subscription) {
                $order2 = Order::create([
                    'user_id' => $client->id,
                    'subscription_id' => $subscription->id,
                    'driver_id' => $drivers->random()->id,
                    'type' => 'subscription',
                    'total_amount' => $subscription->price,
                    'status' => 'validated',
                    'delivery_address' => $deliveryAddress,
                ]);
            }
            
            // Commande en livraison
            $order3 = Order::create([
                'user_id' => $client->id,
                'type' => 'single',
                'total_amount' => 0,
                'status' => 'in_delivery',
                'delivery_address' => $deliveryAddress,
            ]);
            
            $total3 = 0;
            for ($i = 0; $i < rand(1, 2); $i++) {
                $meal = $meals->random();
                $quantity = rand(1, 2);
                $itemTotalPrice = $meal->price_usd * $quantity; // Utiliser price_usd
                $total3 += $itemTotalPrice;
                
                OrderItem::create([
                    'order_id' => $order3->id,
                    'meal_id' => $meal->id,
                    'quantity' => $quantity,
                    'unit_price' => $meal->price_usd, // Utiliser price_usd
                    'total_price' => $itemTotalPrice,
                ]);
            }
            $order3->update(['total_amount' => $total3]);
            
            // Commande livrée
            $order4 = Order::create([
                'user_id' => $client->id,
                'type' => 'single',
                'total_amount' => 0,
                'status' => 'delivered',
                'delivery_address' => $deliveryAddress,
            ]);
            
            $total4 = 0;
            for ($i = 0; $i < rand(1, 2); $i++) {
                $meal = $meals->random();
                $quantity = rand(1, 2);
                $itemTotalPrice = $meal->price_usd * $quantity; // Utiliser price_usd
                $total4 += $itemTotalPrice;
                
                OrderItem::create([
                    'order_id' => $order4->id,
                    'meal_id' => $meal->id,
                    'quantity' => $quantity,
                    'unit_price' => $meal->price_usd, // Utiliser price_usd
                    'total_price' => $itemTotalPrice,
                ]);
            }
            $order4->update(['total_amount' => $total4]);
        }
    }
}
