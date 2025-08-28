<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    /** @use HasFactory<\Database\Factories\UserFactory> */
    use HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'name',
        'email',
        'phone',
        'address',
        'role',
        'password',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var list<string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }

    // Relations
    public function orders()
    {
        return $this->hasMany(Order::class);
    }

    public function subscriptions()
    {
        return $this->hasMany(Subscription::class);
    }

    public function deliveries()
    {
        return $this->hasMany(Delivery::class, 'driver_id');
    }

    public function assignedOrders()
    {
        return $this->hasMany(Order::class, 'driver_id');
    }

    // Scopes
    public function scopeAdmins($query)
    {
        return $query->where('role', 'admin');
    }

    public function scopeClients($query)
    {
        return $query->where('role', 'client');
    }

    public function scopeDrivers($query)
    {
        return $query->where('role', 'driver');
    }

    // Methods
    public function isAdmin()
    {
        // Adaptez selon votre structure (champ 'role' ou 'is_admin')
        return $this->role === 'admin' || $this->is_admin === true;
    }

    public function isClient()
    {
        return $this->role === 'client';
    }

    public function isDriver()
    {
        // Adaptez selon votre structure (champ 'role' ou 'is_driver')
        return $this->role === 'driver' || $this->is_driver === true;
    }
}
