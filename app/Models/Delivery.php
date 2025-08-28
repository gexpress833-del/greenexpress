<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Delivery extends Model
{
    use HasFactory;

    protected $fillable = [
        'order_id',
        'driver_id',
        'secure_code_entered',
        'code_validated',
        'delivery_time',
        'notes',
    ];

    protected $casts = [
        'code_validated' => 'boolean',
        'delivery_time' => 'datetime',
    ];

    // Relations
    public function order()
    {
        return $this->belongsTo(Order::class);
    }

    public function driver()
    {
        return $this->belongsTo(User::class, 'driver_id');
    }

    // Methods
    public function validateCode($code)
    {
        $invoice = $this->order->invoice;
        if ($invoice && $invoice->secure_code === $code) {
            $this->update([
                'secure_code_entered' => $code,
                'code_validated' => true,
                'delivery_time' => now(),
            ]);
            
            $this->order->markAsDelivered();
            return true;
        }
        
        return false;
    }
}
