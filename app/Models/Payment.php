<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Payment extends Model
{
    use HasFactory;
    protected $fillable = [
        'id',
        'order_id',
        'amount',
        'currency',
        'method',
        'status',
        'transaction_id',
        'transaction_data',
        'price',
        'quantity',
    ];

    protected static function booted()
    {
        static::creating(function (Payment $payment) {
            $payment->amount = $payment->price * $payment->quantity;
        });
    }
}
