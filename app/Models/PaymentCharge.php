<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PaymentCharge extends Model
{
    use HasFactory;

    public const STATUS_PAID = 'paid';
    public const STATUS_PENDING = 'pending';
    public const STATUS_FAILED = 'failed';
    public const STATUS_CHALLENGE = 'challenge';

    protected $guarded = [];

    public function subscriptionPayment()
    {
        return $this->belongsTo(Subscription::class);
    }
}
