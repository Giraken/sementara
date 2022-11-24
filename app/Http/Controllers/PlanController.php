<?php

namespace App\Http\Controllers;

use App\Contracts\Logable;
use App\Models\Plan;
use App\Models\Country;
use App\Models\PlanPrice;
use App\Models\Product;
use App\Services\CustomLogger;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Inertia\Inertia;

class PlanController extends Controller
{
    private Logable $customLogger;

    public function __construct(CustomLogger $c)
    {
        $this->customLogger = $c;
    }

    /**
     * Select2 plan.
     *
     * @param Request $request
     * @return Response
     */
    public function select2(Request $request)
    {
        echo Plan::select2($request);
    }

    public function index()
    {
        $itemsPerPage = 16;

        $result = Plan::whereAvailablePlans()
            ->with(['currencies', 'product' => fn ($q) => Product::whereAvailableProducts($q)])
            ->paginate($itemsPerPage);

        return Inertia::render('Product/Index', ['response' => $result]);
    }

    public function checkout(string $planId)
    {
        $plan = Plan::whereAvailablePlans()
            ->with([
                'currencies',
                'currencies.paymentServiceProviders',
                'product' => fn ($q) => Product::whereAvailableProducts($q),
            ])
            ->find($planId);

        if ($plan === null) {
            return Inertia::render('Error/404', ['error' => ['message' => 'Plan not found']]);
        }

        // Find PayPal plan price (PayPal is in USD currency)
        $paypalPlan = PlanPrice::where('plan_id', $planId)
            ->where('currency_id', '=', fn ($query) => $query->select('id')->from('currencies')->where('code', '=', 'USD'))
            ->with(['currency'])
            ->first();

        // Find Midtrans plan price (Midtrans is in IDR currency)
        $midtransPlan = PlanPrice::where('plan_id', $planId)
            ->where('currency_id', '=', fn ($query) => $query->select('id')->from('currencies')->where('code', '=', 'IDR'))
            ->with(['currency'])
            ->first();

        $countries = Country::all(['id', 'name']);

        return Inertia::render('Product/Checkout', [
            'plan' => $plan,
            'payment' => [
                'paypal' => $paypalPlan,
                'midtrans' => $midtransPlan,
            ],
            'countries' => $countries,
        ]);
    }

    public function customLogger()
    {
        $message = $this->customLogger->log('Hello world');
        return response()->json(['message' => $message], 200);
    }
}
