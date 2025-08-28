<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class SubscriptionPlan extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'category_type',
        'duration_type',
        'unit_price_per_meal_cdf',
        'package_price_cdf',
        'meal_count',
        'benefits',
        'description',
    ];

    protected $casts = [
        'unit_price_per_meal_cdf' => 'decimal:2',
        'package_price_cdf' => 'decimal:2',
        'category_type' => 'string',
        'duration_type' => 'string',
    ];
}
