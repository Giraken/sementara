<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\Pivot;

class SubscriptionMembership extends Pivot
{
    use HasFactory;

    protected $table = 'subscription_memberships';

    public $incrementing = true;

    protected $fillable = [
        'user_id',
        'subscription_id',
        'is_favorite',
    ];
}
