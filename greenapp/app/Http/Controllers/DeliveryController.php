<?php

namespace App\Http\Controllers;

use App\Models\Delivery;
use App\Models\Order;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class DeliveryController extends Controller
{
    public function index()
    {
        $deliveries = Delivery::where('user_id', Auth::id())->get();
        return view('delivery.index', compact('deliveries'));
    }

    public function show($id)
    {
        $delivery = Delivery::findOrFail($id);
        return view('delivery.show', compact('delivery'));
    }

    public function validateDelivery(Request $request, $id)
    {
        $request->validate([
            'secure_code' => 'required|string',
        ]);

        $delivery = Delivery::findOrFail($id);
        
        if ($delivery->secure_code === $request->secure_code) {
            $delivery->status = 'Delivered';
            $delivery->save();

            return response()->json(['message' => 'Delivery validated successfully.'], 200);
        }

        return response()->json(['message' => 'Invalid secure code.'], 403);
    }
}