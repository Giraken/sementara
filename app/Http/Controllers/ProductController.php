<?php

namespace App\Http\Controllers;

use App\Models\Plan;
use Inertia\Inertia;

class ProductController extends Controller
{
    public function planCheckout(string $planId)
    {
        $availableProduct = fn ($query) => $query->where('is_visible', 1)->where('status', 'active');
        $plan = Plan::activePlans()
            ->with(['product' => $availableProduct, 'currencies'])
            ->find($planId);

        if (!$plan) {
            return Inertia::render('Errors/404');
        }

        return Inertia::render('Product/Checkout', [
            'plan' => $plan,
        ]);
    }
}
