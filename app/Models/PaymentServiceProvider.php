<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Query\Builder;

class PaymentServiceProvider extends Model
{
    use HasFactory;

    protected $guarded = [];

    public function subscriptions()
    {
        return $this->hasMany(Subscription::class, 'current_payment_service_provider_id', 'id');
    }

    public function subscriptionPayments()
    {
        return $this->hasMany(SubscriptionPayment::class);
    }

    public function currencies()
    {
        return $this->belongsToMany(Currency::class, 'payment_service_provider_supported_currencies', 'payment_service_provider_id', 'currency_id');
    }

    public static function whereItIsPaypal(Builder $query = null)
    {
        return $query
            ? $query->where('name', 'paypal')
            : self::where('name', 'paypal');
    }
}
