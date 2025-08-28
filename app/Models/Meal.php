<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Meal extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'description',
        'price_cdf', // Prix en Franc Congolais
        'price_usd', // Prix en Dollar US
        'image',
        'is_available',
        'category_id', // Nouvelle colonne
    ];

    protected $casts = [
        'price_cdf' => 'decimal:2',
        'price_usd' => 'decimal:2',
        'is_available' => 'boolean',
    ];

    // Relations
    public function orderItems()
    {
        return $this->hasMany(OrderItem::class);
    }

    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    // Scopes
    public function scopeAvailable($query)
    {
        return $query->where('is_available', true);
    }

    // Accesseurs pour les prix formatés
    public function getFormattedPriceCdfAttribute()
    {
        return number_format($this->price_cdf, 0, ',', ' ') . ' FC';
    }

    public function getFormattedPriceUsdAttribute()
    {
        return '$' . number_format($this->price_usd, 2);
    }

    // Méthode pour convertir CDF vers USD (taux dynamique)
    public function convertCdfToUsd($cdfAmount)
    {
        return \App\Models\ExchangeRate::convertCdfToUsd($cdfAmount);
    }

    // Méthode pour convertir USD vers CDF (taux dynamique)
    public function convertUsdToCdf($usdAmount)
    {
        return \App\Models\ExchangeRate::convertUsdToCdf($usdAmount);
    }
}
