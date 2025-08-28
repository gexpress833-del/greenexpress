<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\ClientController;
use App\Http\Controllers\DeliveryController;
use App\Http\Controllers\InvoiceController;

// Admin routes
Route::middleware(['admin'])->group(function () {
    Route::get('/admin/dashboard', [AdminController::class, 'dashboard'])->name('admin.dashboard');
    Route::resource('admin/menu', AdminController::class)->only(['index', 'store', 'update', 'destroy']);
    Route::resource('admin/subscriptions', AdminController::class)->only(['index', 'store', 'update', 'destroy']);
    Route::resource('admin/orders', AdminController::class)->only(['index', 'show', 'update']);
    Route::get('/admin/invoices/{order}', [InvoiceController::class, 'generate'])->name('admin.invoices.generate');
});

// Client routes
Route::middleware(['client'])->group(function () {
    Route::get('/menu', [ClientController::class, 'index'])->name('client.menu');
    Route::post('/order', [ClientController::class, 'placeOrder'])->name('client.order.place');
    Route::get('/subscriptions', [ClientController::class, 'subscriptions'])->name('client.subscriptions');
    Route::get('/orders/history', [ClientController::class, 'orderHistory'])->name('client.orders.history');
});

// Delivery routes
Route::middleware(['delivery'])->group(function () {
    Route::get('/delivery/dashboard', [DeliveryController::class, 'dashboard'])->name('delivery.dashboard');
    Route::get('/delivery/orders', [DeliveryController::class, 'assignedOrders'])->name('delivery.orders.assigned');
    Route::post('/delivery/validate/{order}', [DeliveryController::class, 'validateDelivery'])->name('delivery.validate');
});