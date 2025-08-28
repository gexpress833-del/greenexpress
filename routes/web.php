<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\DashboardController;

// Routes publiques
Route::get('/', function () {
    return redirect()->route('login');
});

// Routes d'authentification
Route::middleware('guest')->group(function () {
    Route::get('/login', [AuthController::class, 'showLogin'])->name('login');
    Route::post('/login', [AuthController::class, 'login']);
    Route::get('/register', [AuthController::class, 'showRegister'])->name('register');
    Route::post('/register', [AuthController::class, 'register']);
});

// Routes protégées
Route::middleware('auth')->group(function () {
    Route::post('/logout', [AuthController::class, 'logout'])->name('logout');
    
    // Routes des commandes
    Route::resource('orders', OrderController::class);
    Route::post('/orders/{order}/validate', [OrderController::class, 'validateOrder'])->name('orders.validate');
    Route::post('/orders/{order}/assign-driver', [OrderController::class, 'assignDriver'])->name('orders.assign-driver');
    Route::get('/orders/{order}/invoice/download', [OrderController::class, 'downloadInvoice'])->name('orders.invoice.download');
    // Route signée pour le téléchargement temporaire de la facture (pour WhatsApp)
    Route::get('/invoice/{invoice}/download-signed', [OrderController::class, 'downloadSignedInvoice'])->name('invoice.download.signed');
    
    // Routes Admin
    Route::middleware('admin')->group(function () {
        Route::get('/admin/dashboard', [DashboardController::class, 'admin'])->name('admin.dashboard');
        Route::get('/admin/meals', [DashboardController::class, 'meals'])->name('admin.meals');
        Route::post('/admin/meals', [DashboardController::class, 'storeMeal'])->name('admin.meals.store');
        Route::put('/admin/meals/{meal}', [DashboardController::class, 'updateMeal'])->name('admin.meals.update');
        Route::delete('/admin/meals/{meal}', [DashboardController::class, 'deleteMeal'])->name('admin.meals.destroy');
        Route::get('/admin/meals/{meal}/show', [DashboardController::class, 'showMeal'])->name('admin.meals.show'); // API for fetching meal data
        Route::get('/admin/subscriptions', [DashboardController::class, 'subscriptions'])->name('admin.subscriptions');
        Route::post('/admin/subscriptions', [DashboardController::class, 'storeSubscription'])->name('admin.subscriptions.store');
        Route::put('/admin/subscriptions/{subscription}', [DashboardController::class, 'updateSubscription'])->name('admin.subscriptions.update');
        Route::delete('/admin/subscriptions/{subscription}', [DashboardController::class, 'deleteSubscription'])->name('admin.subscriptions.destroy');
        Route::get('/admin/subscriptions/{subscription}/show', [DashboardController::class, 'showSubscription'])->name('admin.subscriptions.show'); // API for fetching subscription data
        Route::post('/admin/subscriptions/{subscription}/validate', [DashboardController::class, 'validateSubscription'])->name('admin.subscriptions.validate');
        Route::post('/admin/subscriptions/{subscription}/reject', [DashboardController::class, 'rejectSubscription'])->name('admin.subscriptions.reject');

        // Routes for Subscription Plans
        Route::get('/admin/subscription-plans', [DashboardController::class, 'subscriptionPlans'])->name('admin.subscription-plans');
        Route::post('/admin/subscription-plans', [DashboardController::class, 'storeSubscriptionPlan'])->name('admin.subscription-plans.store');
        Route::put('/admin/subscription-plans/{subscriptionPlan}', [DashboardController::class, 'updateSubscriptionPlan'])->name('admin.subscription-plans.update');
        Route::delete('/admin/subscription-plans/{subscriptionPlan}', [DashboardController::class, 'deleteSubscriptionPlan'])->name('admin.subscription-plans.destroy');
        Route::get('/admin/subscription-plans/{subscriptionPlan}/show', [DashboardController::class, 'showSubscriptionPlan'])->name('admin.subscription-plans.show'); // API for fetching plan data

        Route::get('/admin/users', [DashboardController::class, 'users'])->name('admin.users');
        Route::post('/admin/users', [DashboardController::class, 'storeUser'])->name('admin.users.store');
        Route::delete('/admin/users/{user}', [DashboardController::class, 'deleteUser'])->name('admin.users.destroy');
        Route::get('/admin/exchange-rates', [DashboardController::class, 'exchangeRates'])->name('admin.exchange-rates');
        Route::post('/admin/exchange-rates', [DashboardController::class, 'updateExchangeRate'])->name('admin.exchange-rates.update');
        Route::get('/admin/profile', [DashboardController::class, 'adminProfile'])->name('admin.profile');
        Route::put('/admin/profile', [DashboardController::class, 'updateAdminProfile'])->name('admin.profile.update');
        Route::put('/admin/password', [DashboardController::class, 'updateAdminPassword'])->name('admin.password.update');

        // Routes for Categories
        Route::get('/admin/categories', [DashboardController::class, 'categories'])->name('admin.categories');
        Route::post('/admin/categories', [DashboardController::class, 'storeCategory'])->name('admin.categories.store');
        Route::put('/admin/categories/{category}', [DashboardController::class, 'updateCategory'])->name('admin.categories.update');
        Route::delete('/admin/categories/{category}', [DashboardController::class, 'deleteCategory'])->name('admin.categories.destroy');
        Route::get('/admin/categories/{category}/show', [DashboardController::class, 'showCategory'])->name('admin.categories.show'); // API for fetching category data
    });
    
    // Routes Client
    Route::middleware('client')->group(function () {
        Route::get('/client/dashboard', [DashboardController::class, 'client'])->name('client.dashboard');
        Route::get('/client/profile', [DashboardController::class, 'profile'])->name('client.profile');
        Route::put('/client/profile', [DashboardController::class, 'updateProfile'])->name('client.profile.update');
        Route::put('/client/password', [DashboardController::class, 'updatePassword'])->name('client.password.update');
        Route::get('/client/exchange-rate', [DashboardController::class, 'clientExchangeRate'])->name('client.exchange-rate');
        Route::get('/client/subscription-plans', [DashboardController::class, 'clientSubscriptionPlans'])->name('client.subscription-plans');
        Route::post('/client/subscribe', [DashboardController::class, 'subscribeToPlan'])->name('client.subscribe');
    });
    
    // Routes Driver
    Route::middleware('driver')->group(function () {
        Route::get('/driver/dashboard', [DashboardController::class, 'driver'])->name('driver.dashboard');
        Route::get('/driver/deliveries', [DashboardController::class, 'deliveries'])->name('driver.deliveries');
        Route::post('/orders/{order}/start-delivery', [OrderController::class, 'startDelivery'])->name('orders.start-delivery'); // Moved from above
        Route::post('/orders/{order}/validate-delivery', [OrderController::class, 'validateDelivery'])->name('orders.validate-delivery'); // Moved from above
        Route::get('/driver/profile', [DashboardController::class, 'driverProfile'])->name('driver.profile');
        Route::put('/driver/profile', [DashboardController::class, 'updateDriverProfile'])->name('driver.profile.update');
        Route::put('/driver/password', [DashboardController::class, 'updateDriverPassword'])->name('driver.password.update');
        Route::get('/driver/exchange-rate', [DashboardController::class, 'driverExchangeRate'])->name('driver.exchange-rate');
    });
});
