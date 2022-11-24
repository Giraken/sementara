<?php

namespace App\Http\Controllers;

use App\Models\Subscription;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Inertia\Inertia;

class BillingController extends Controller
{

    public function index()
    {
        $user = Auth::user();
        $subscriptions = Subscription::where('customer_id', $user->id)
            ->where('status', Subscription::STATUS_ACTIVE)
            ->where('current_period_ends_at', '>', now())
            ->with([
                'plan' => fn ($q) => $q->select('id', 'name', 'product_id'),
                'plan.product' => fn ($q) => $q->select('id', 'name'),
                'subscriptionPayments' => fn ($q) => $q->where('is_active', true),
                'subscriptionPayments.paymentServiceProvider'
            ])
            ->get();

        return Inertia::render('Billing/Index', [
            'activeSubscriptions' => $subscriptions->map(function ($s) {
                return [
                    'id' => $s->id,
                    'status' => $s->status,
                    'current_period_ends_at' => $s->current_period_ends_at,
                    'plan' => [
                        'id' => $s->plan->id,
                        'name' => $s->plan->name,
                        'product' => [
                            'id' => $s->plan->product->id,
                            'name' => $s->plan->product->name,
                        ]
                    ],
                    'payment' => [
                        'assigned_subscription_id' => $s->subscriptionPayments[0]->assigned_subscription_id,
                        'cancel_url' => route("{$s->subscriptionPayments[0]->paymentServiceProvider->name}.subscription.cancel"),
                        'provider' => [
                            'id' => $s->subscriptionPayments[0]->paymentServiceProvider->id,
                            'name' => $s->subscriptionPayments[0]->paymentServiceProvider->name,
                        ]
                    ]
                ];
            }),
        ]);
    }
}
