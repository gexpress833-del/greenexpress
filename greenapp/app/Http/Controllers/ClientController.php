<?php

namespace App\Http\Controllers;

use App\Models\Meal;
use App\Models\Order;
use App\Models\Subscription;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ClientController extends Controller
{
    public function browseMenu()
    {
        $meals = Meal::all();
        return view('client.menu', compact('meals'));
    }

    public function placeOrder(Request $request)
    {
        $request->validate([
            'meal_id' => 'required|exists:meals,id',
        ]);

        $order = new Order();
        $order->user_id = Auth::id();
        $order->meal_id = $request->meal_id;
        $order->status = 'pending';
        $order->save();

        // Logic to send confirmation via WhatsApp can be added here

        return redirect()->back()->with('success', 'Order placed successfully!');
    }

    public function manageSubscriptions()
    {
        $subscriptions = Subscription::all();
        return view('client.subscriptions', compact('subscriptions'));
    }

    public function viewOrderHistory()
    {
        $orders = Order::where('user_id', Auth::id())->get();
        return view('client.order_history', compact('orders'));
    }

    public function checkOrderStatus($orderId)
    {
        $order = Order::findOrFail($orderId);
        return view('client.order_status', compact('order'));
    }
}