<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Customer;
use App\Models\Plan;
use App\Models\Subscription;
use Auth;
use Illuminate\Http\Request;
use Response;

/**
 * /api/v1/subscriptions - API controller for managing subscriptions.
 */
class SubscriptionController extends Controller
{
    /**
     * Display all subscriptions.
     *
     * GET /api/v1/campaigns
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $user = Auth::guard('api')->user();

        $subscriptions = Subscription::select('*')
            ->paginate($request->per_page ? $request->per_page : 25);

        return Response::json($subscriptions, 200);
    }

    /**
     * Subscribe customer to a plan (For admin only).
     *
     * POST /api/v1/subscriptions
     *
     * @param Request $request All supscription information
     * @param string $customer_uid Customer's uid
     * @param string $plan_uid Plan's uid
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $user = Auth::guard('api')->user();
        $customer = Customer::findByUid($request->customer_uid);
        $plan = Plan::findByUid($request->plan_uid);

        // check if customer exists
        if (!is_object($customer)) {
            return Response::json(['status' => 0, 'message' => 'Customer not found'], 404);
        }

        // check if plan exists
        if (!is_object($plan)) {
            return Response::json(['status' => 0, 'message' => 'Plan not found'], 404);
        }

        // authorize
        if (!$user->can('assignPlan', $customer)) {
            return Response::json(['status' => 0, 'message' => 'Unauthorized'], 401);
        }

        // check if item active
        if (!$plan->isActive()) {
            return Response::json(['status' => 0, 'message' => 'Plan is not active'], 404);
        }

        $customer->assignPlan($plan);

        return Response::json([
            'status' => 1,
            'message' => 'Assigned ' . $customer->user->displayName() . ' plan to ' . $plan->name . ' successfully.',
            'customer_uid' => $customer->uid,
            'plan_uid' => $plan->uid,
        ], 200);
    }
}
