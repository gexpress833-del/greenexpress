<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\ClientController;
use App\Http\Controllers\DeliveryController;
use App\Http\Controllers\InvoiceController;

// Admin routes
Route::middleware(['auth:sanctum', 'admin'])->group(function () {
    Route::get('/admin/menu', [AdminController::class, 'getMenu']);
    Route::post('/admin/menu', [AdminController::class, 'updateMenu']);
    Route::get('/admin/orders', [AdminController::class, 'getOrders']);
    Route::post('/admin/orders/{order}/validate', [AdminController::class, 'validateOrder']);
    Route::get('/admin/statistics', [AdminController::class, 'getStatistics']);
});

// Client routes
Route::middleware(['auth:sanctum', 'client'])->group(function () {
    Route::get('/client/menu', [ClientController::class, 'browseMenu']);
    Route::post('/client/orders', [ClientController::class, 'placeOrder']);
    Route::get('/client/orders', [ClientController::class, 'getOrderHistory']);
    Route::get('/client/subscriptions', [ClientController::class, 'getSubscriptions']);
});

// Delivery routes
Route::middleware(['auth:sanctum', 'delivery'])->group(function () {
    Route::get('/delivery/orders', [DeliveryController::class, 'getAssignedOrders']);
    Route::post('/delivery/orders/{order}/validate', [DeliveryController::class, 'validateDelivery']);
});

// Invoice routes
Route::middleware(['auth:sanctum'])->group(function () {
    Route::get('/invoices/{invoice}', [InvoiceController::class, 'getInvoice']);
});