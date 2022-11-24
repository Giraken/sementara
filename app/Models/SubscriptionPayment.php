<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SubscriptionPayment extends Model
{
    use HasFactory;

    protected $guarded = [];

    protected $casts = [
        'metadata' => 'array',
    ];

    public function subscription()
    {
        return $this->belongsTo(Subscription::class);
    }

    public function paymentCharges()
    {
        return $this->hasMany(PaymentCharge::class);
    }

    public function paymentServiceProvider()
    {
        return $this->belongsTo(PaymentServiceProvider::class);
    }
}
