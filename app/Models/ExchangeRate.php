<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ExchangeRate extends Model
{
    use HasFactory;

    protected $fillable = [
        'from_currency',
        'to_currency',
        'rate',
        'inverse_rate',
        'is_active',
        'last_updated',
    ];

    protected $casts = [
        'rate' => 'decimal:6',
        'inverse_rate' => 'decimal:2',
        'is_active' => 'boolean',
        'last_updated' => 'datetime',
    ];

    // Scopes
    public function scopeActive($query)
    {
        return $query->where('is_active', true);
    }

    public function scopeCdfToUsd($query)
    {
        return $query->where('from_currency', 'CDF')->where('to_currency', 'USD');
    }

    // Méthodes statiques pour obtenir le taux actuel
    public static function getCurrentRate()
    {
        return self::active()->cdfToUsd()->first();
    }

    public static function getCdfToUsdRate()
    {
        $rate = self::getCurrentRate();
        return $rate ? $rate->rate : 0.00037; // Taux par défaut
    }

    public static function getUsdToCdfRate()
    {
        $rate = self::getCurrentRate();
        return $rate ? $rate->inverse_rate : 2700; // Taux par défaut
    }

    // Méthodes de conversion
    public static function convertCdfToUsd($cdfAmount)
    {
        $rate = self::getCdfToUsdRate();
        return round($cdfAmount * $rate, 2);
    }

    public static function convertUsdToCdf($usdAmount)
    {
        $rate = self::getUsdToCdfRate();
        return round($usdAmount * $rate, 0);
    }
}
