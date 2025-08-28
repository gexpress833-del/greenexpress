<?php

namespace App\Policies;

use App\Models\Order;
use App\Models\User;

class OrderPolicy
{
    /**
     * Determine whether the user can view any models.
     */
    public function viewAny(User $user): bool
    {
        return true; // Tous les utilisateurs connectés peuvent voir la liste
    }

    /**
     * Determine whether the user can view the model.
     */
    public function view(User $user, Order $order): bool
    {
        // Admin peut voir toutes les commandes
        if ($user->isAdmin()) {
            return true;
        }
        
        // Client peut voir ses propres commandes
        if ($user->isClient()) {
            return $order->user_id === $user->id;
        }
        
        // Livreur peut voir les commandes qui lui sont assignées
        if ($user->isDriver()) {
            return $order->driver_id === $user->id;
        }
        
        return false;
    }

    /**
     * Determine whether the user can create models.
     */
    public function create(User $user): bool
    {
        // Seuls les clients peuvent créer des commandes
        return $user->isClient();
    }

    /**
     * Determine whether the user can update the model.
     */
    public function update(User $user, Order $order): bool
    {
        // Admin peut modifier toutes les commandes
        if ($user->isAdmin()) {
            return true;
        }
        
        // Client peut modifier ses propres commandes en attente
        if ($user->isClient() && $order->user_id === $user->id) {
            return $order->status === 'pending';
        }
        
        return false;
    }

    /**
     * Determine whether the user can delete the model.
     */
    public function delete(User $user, Order $order): bool
    {
        // Seul l'admin peut supprimer des commandes
        return $user->isAdmin();
    }

    /**
     * Determine whether the user can validate the order.
     */
    public function validate(User $user, Order $order): bool
    {
        // Seul l'admin peut valider les commandes
        return $user->isAdmin() && $order->status === 'pending';
    }

    /**
     * Determine whether the user can deliver the order.
     */
    public function deliver(User $user, Order $order): bool
    {
        // Le livreur assigné peut livrer la commande
        return $user->isDriver() && 
               $order->driver_id === $user->id && 
               in_array($order->status, ['validated', 'in_delivery']);
    }
}
