<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Subscription extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'name',
        'category_type',
        'duration_type',
        'unit_price_per_meal_cdf',
        'package_price_cdf',
        'meal_count',
        'plan_description',
        'start_date',
        'end_date',
        'status',
        'reason',
    ];

    protected $casts = [
        'start_date' => 'datetime',
        'end_date' => 'datetime',
        'unit_price_per_meal_cdf' => 'decimal:2',
        'package_price_cdf' => 'decimal:2',
        'status' => 'string',
        'category_type' => 'string',
        'duration_type' => 'string',
    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function orders(): HasMany
    {
        return $this->hasMany(Order::class);
    }

    // Scopes
    public function scopeActive($query)
    {
        return $query->where('status', 'active')->where('end_date', '>=', now());
    }

    public function scopeExpired($query)
    {
        return $query->whereIn('status', ['expired', 'cancelled'])->orWhere('end_date', '<', now());
    }

    // Helper method to check if subscription is active
    public function isActive(): bool
    {
        return $this->status === 'active' && $this->end_date->isFuture();
    }

    public function getDaysRemainingAttribute(): int
    {
        return now()->diffInDays($this->end_date, false);
    }

    public function isExpiringSoon(): bool
    {
        return $this->isActive() && $this->days_remaining <= 5 && $this->days_remaining >= 0;
    }

    public function isExpired(): bool
    {
        return $this->end_date->isPast() && ($this->status === 'active' || $this->status === 'pending_validation');
    }

    // Nouvel accesseur pour les économies réalisées
    public function getSavingsCdfAttribute(): float
    {
        return $this->unit_price_per_meal_cdf - $this->package_price_cdf;
    }

    public function getFormattedUnitPricePerMealCdfAttribute(): string
    {
        return number_format($this->unit_price_per_meal_cdf, 2) . ' CDF';
    }

    public function getFormattedPackagePriceCdfAttribute(): string
    {
        return number_format($this->package_price_cdf, 2) . ' CDF';
    }

    public function getFormattedSavingsCdfAttribute(): string
    {
        return number_format($this->savings_cdf, 2) . ' CDF';
    }

    // Conversion vers USD (si nécessaire, en utilisant le taux de change)
    public function getUnitPricePerMealUsdAttribute(): float
    {
        return ExchangeRate::convertCdfToUsd($this->unit_price_per_meal_cdf);
    }

    public function getPackagePriceUsdAttribute(): float
    {
        return ExchangeRate::convertCdfToUsd($this->package_price_cdf);
    }

    public function getSavingsUsdAttribute(): float
    {
        return ExchangeRate::convertCdfToUsd($this->savings_cdf);
    }

    public function getFormattedUnitPricePerMealUsdAttribute(): string
    {
        return '$' . number_format($this->unit_price_per_meal_usd, 2);
    }

    public function getFormattedPackagePriceUsdAttribute(): string
    {
        return '$' . number_format($this->package_price_usd, 2);
    }

    public function getFormattedSavingsUsdAttribute(): string
    {
        return '$' . number_format($this->savings_usd, 2);
    }
}
