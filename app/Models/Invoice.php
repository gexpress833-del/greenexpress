<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Invoice extends Model
{
    use HasFactory;

    protected $fillable = [
        'order_id',
        'invoice_number',
        'secure_code',
        'amount',
        'pdf_path',
        'whatsapp_sent',
        'sent_at',
    ];

    protected $casts = [
        'amount' => 'decimal:2',
        'whatsapp_sent' => 'boolean',
        'sent_at' => 'datetime',
    ];

    // Relations
    public function order()
    {
        return $this->belongsTo(Order::class);
    }

    // Methods
    public function markAsSent()
    {
        $this->update([
            'whatsapp_sent' => true,
            'sent_at' => now(),
        ]);
    }

    public function generateSecureCode()
    {
        return strtoupper(substr(md5(uniqid()), 0, 8)) . '-' . strtoupper(substr(md5(uniqid()), 0, 4));
    }
}
