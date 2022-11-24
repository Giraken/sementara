<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\Pivot;

class PlanPrice extends Pivot
{
    use HasFactory;

    protected $table = 'plan_prices';

    public $incrementing = true;

    protected $fillable = [
        'plan_id',
        'currency_id',
        'price',
        'price_per_seat',
    ];

    public function plan()
    {
        return $this->belongsTo(Plan::class);
    }

    public function currency()
    {
        return $this->belongsTo(Currency::class);
    }

    public function paypalRegisteredPlan()
    {
        return $this->hasOne(PaypalRegisteredPlan::class, 'plan_price_id', 'id');
    }
}
