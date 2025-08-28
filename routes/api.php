<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\DashboardController;

Route::middleware(['auth:sanctum', 'admin'])->group(function () {
    Route::get('/subscriptions/{subscription}', [DashboardController::class, 'showSubscription']);
});
