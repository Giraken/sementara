<?php

namespace App\Http\Controllers;

use App\Models\Invoice;
use App\Models\Plan;
use App\Models\Subscription;
use App\Models\SubscriptionMembership;
use App\Models\Team;
use App\Models\User;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Arr;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Inertia\Inertia;

//use App\Models\Setting;

//use App\Cashier\Cashier;
//use App\Cashier\Services\StripeGatewayService;

class SubscriptionController extends Controller
{
    public function index(Request $request)
    {
        $itemsPerPage = 16;
        $previewMemberMax = 4;

        $user = Auth::user();

        $userFavoriteSubscriptions = $request->query('page', 1) > 1
            ? []
            : $user
            ->subscriptionFavorites()
            ->with(['users' => fn ($query) => $query->limit($previewMemberMax), 'plan', 'plan.product'])
            ->orderBy('updated_at', 'desc')
            ->limit(4)
            ->get();

        $userNormalSubscriptions = $user
            ->subscriptions()
            ->with(['users' => fn ($query) => $query->limit($previewMemberMax), 'plan', 'plan.product'])
            ->wherePivot('is_favorite', 0)
            ->paginate($itemsPerPage);

        return Inertia::render('Subscription/Index', [
            'favoriteSubscriptions' => $userFavoriteSubscriptions,
            'normalSubscriptions' => $userNormalSubscriptions,
        ]);
    }

    public function favorites()
    {
        $user = Auth::user();
        $previewMemberMax = 3;
        $itemsPerPage = 16;

        $favoriteSubscriptions = $user
            ->subscriptionFavorites()
            ->with(['users' => fn ($query) => $query->limit($previewMemberMax), 'plan', 'plan.product'])
            ->orderBy('updated_at', 'desc')
            ->paginate($itemsPerPage);

        return Inertia::render('Subscription/Favorites', [
            'subscriptions' => $favoriteSubscriptions,
        ]);
    }

    public function show(Request $request, string $subscriptionId)
    {
        $query = $request->query('keyword') ?? '';

        $usersQuery = User::where(DB::raw('LOWER(name)'), 'LIKE', '%' . strtolower($query) . '%')
            ->orWhere(DB::raw('LOWER(email)'), 'LIKE', '%' . strtolower($query) . '%')
            ->limit(10);

        $teamsQuery = Team::where(DB::raw('LOWER(name)'), 'LIKE', '%' . $query . '%')
            ->limit(10);

        $subscrption = Subscription::with('users', 'plan', 'plan.product')->find($subscriptionId);
        if (!$subscrption) {
            return Inertia::render('Error/404', ['error' => ['message' => 'Not Found', 'description' => 'Subscription is not found']]);
        }

        $subscriptionMemberIds = $subscrption->users->map(fn ($user) => $user->id);
        if (!$subscriptionMemberIds->contains(Auth::id())) {
            return Inertia::render('Error/403', [
                'error' => [
                    'message' => 'Unauthorized',
                    'description' => 'You cannot access this subscription',
                ],
            ]);
        }

        $isFavorite = $subscrption->users->first(fn ($user) => $user->id == Auth::id())->pivot->is_favorite;

        return Inertia::render('Subscription/Show', [
            'subscription' => $subscrption,
            'isFavorite' => $isFavorite,
            'users' => Inertia::lazy(fn () => $usersQuery->get(['id', 'name', 'email', 'profile_photo_path'])->toArray()),
            'teams' => Inertia::lazy(fn () => $teamsQuery->get(['id', 'name'])->toArray()),
        ]);
    }

    public function storeBulkMemberships(Request $request, string $subscriptionId)
    {
        $validated = validator(array_merge($request->route()->parameters(), $request->all()), [
            'subscription_id' => ['required', 'integer', 'min:1'],
            'user_ids' => ['array'],
            'team_ids' => ['array'],
            'user_ids.*' => ['integer', 'min:1'],
            'team_ids.*' => ['integer', 'min:1'],
        ])->validate();

        $toInt = fn ($i) => (int) $i;

        $teamIds = collect(Arr::exists($validated, 'team_ids') ? $validated['team_ids'] : [])->map($toInt);
        $userIds = collect(Arr::exists($validated, 'user_ids') ? $validated['user_ids'] : [])->map($toInt);

        // dd($teamIds, $userIds);

        if ($userIds->isEmpty() && $teamIds->isEmpty()) {
            return redirect()->back()->withErrors([
                'message' => 'You should provide user ids or team ids in the request',
            ]);
        }

        $subcription = Subscription::find($subscriptionId);
        if (!$subcription) {
            return redirect()->back()->withErrors([
                'message' => 'Subcription not found',
            ]);
        }

        // Check if current user is the owner of the subcription
        if ($subcription->customer_id !== Auth::id()) {
            return redirect()->back()->withErrors([
                'message' => 'You are not authorized to add members to this subcription',
            ]);
        }

        $teams = Team::whereIn('id', $teamIds->toArray())->get();
        foreach ($teams as $team) {
            $userIds->push(...$team->users->pluck('id')->all());
        }

        $newMembers = collect([]);
        $uniqueUserIds = $userIds->unique();
        $now = Carbon::now()->toDateTimeString();
        foreach ($uniqueUserIds as $userId) {
            $newMembers->push([
                'user_id' => $userId,
                'subscription_id' => $subcription->id,
                'created_at' => $now,
                'updated_at' => $now,
            ]);
        }

        // Upsert bulk data
        // source: https://www.amitmerchant.com/insert-or-update-multiple-records-using-upsert-in-laravel8/
        DB::table('subscription_memberships')->upsert($newMembers->toArray(), ['user_id', 'subscription_id']);

        return redirect()->back()->with(['success' => 'Successfully added members']);
    }

    public function destroyBulkMemberships(Request $request, string $subscriptionId)
    {
        $validated = validator(array_merge($request->route()->parameters(), $request->all()), [
            'subscription_id' => ['required', 'integer', 'min:1'],
            'user_ids' => ['array'],
            'team_ids' => ['array'],
            'user_ids.*' => ['integer', 'min:1'],
            'team_ids.*' => ['integer', 'min:1'],
        ])->validate();

        $toInt = fn ($i) => (int) $i;

        $teamIds = collect(Arr::exists($validated, 'team_ids') ? $validated['team_ids'] : [])->map($toInt);
        $userIds = collect(Arr::exists($validated, 'user_ids') ? $validated['user_ids'] : [])->map($toInt);

        if ($userIds->isEmpty() && $teamIds->isEmpty()) {
            return redirect()->back()->withErrors([
                'message' => 'You should provide user ids or team ids in the request',
            ]);
        }

        $subcription = Subscription::find($subscriptionId);
        if (!$subcription) {
            return redirect()->back()->withErrors([
                'message' => 'Subcription not found',
            ]);
        }

        // Check if current user is the owner of the subcription, otherwise is prohibited
        if ($subcription->customer_id !== Auth::id()) {
            return redirect()->back()->withErrors([
                'message' => 'You are not authorized to delete members in this subcription',
            ]);
        }

        // Collect all users from the teams
        $teams = Team::whereIn('id', $teamIds->toArray())->get();
        foreach ($teams as $team) {
            $userIds->push(...$team->users->pluck('id')->all());
        }

        // Delete all that (unique) users (except the owner) from the subcription's members
        $uniqueUserIds = $userIds->unique();
        SubscriptionMembership::where('user_id', '!=', $subcription->customer_id)
            ->whereIn('user_id', $uniqueUserIds->toArray())
            ->where('subscription_id', $subcription->id)
            ->delete();

        return redirect()->back()->with(['success' => 'Successfully deleted members']);
    }

    public function updateFavorite(Request $request)
    {
        $validated = validator($request->route()->parameters(), [
            'action' => 'required|in:add,remove',
            'subscription_id' => 'required|integer|min:1',
        ])->validate();

        $userId = Auth::id();

        $membership = SubscriptionMembership::where('user_id', $userId)
            ->where('subscription_id', $validated['subscription_id'])
            ->first();

        if (!$membership) {
            return redirect()->back()->withErrors(['error' => 'Subscription membership not found']);
        }

        $membership->is_favorite = $validated['action'] === 'add' ? 1 : 0;
        $result = $membership->save();
        if (!$result) {
            return redirect()->back()->withErrors(['error' => 'Update failed']);
        }

        return redirect()->back()->with(['success' => 'Successfully updating favorites']);
    }

    public function selectPlan(Request $request)
    {
        //
        $customer = $request->user()->customer;
        $subscription = $customer->subscription;

        return view('subscription.selectPlan', [
            'plans' => Plan::getAvailablePlans(),
            'subscription' => $subscription,
        ]);
    }

    public function init(Request $request)
    {
        // Get current customer
        $customer = $request->user()->customer;
        $subscription = $customer->subscription;
        $plan = Plan::findByUid($request->plan_uid);

        // try to save old invoice billing info
        if (
            $subscription &&
            !$subscription->isEnded() &&
            $subscription->getUnpaidInvoice()
        ) {
            $oldInvoice = $subscription->getUnpaidInvoice();

            $oldBillingInfo = [
                'billing_first_name' => $oldInvoice->billing_first_name,
                'billing_last_name' => $oldInvoice->billing_last_name,
                'billing_address' => $oldInvoice->billing_address,
                'billing_email' => $oldInvoice->billing_email,
                'billing_phone' => $oldInvoice->billing_phone,
                'billing_country_id' => $oldInvoice->billing_country_id,
            ];
        }

        // create new subscription
        $subscription = $customer->subscription;
        $subscription = $customer->assignPlan($plan);

        // create init invoice
        if (!$subscription->invoices()->new()->count()) {
            $invoice = $subscription->createInitInvoice();
        }

        // copy old billing info
        if (isset($oldBillingInfo)) {
            $invoice = $subscription->getUnpaidInvoice();

            $invoice->fill($oldBillingInfo);
            $invoice->save();
        }

        // Check if subscriotion is new
        return redirect()->action('SubscriptionController@billingInformation');
    }

    public function payment(Request $request)
    {
        // Get current customer
        $customer = $request->user()->customer;

        // get invoice
        $invoice = $customer->invoices()->where('uid', '=', $request->invoice_uid)->first();

        if (!$invoice || !$invoice->isNew()) {
            return redirect()->action('SubscriptionController@index');
        }

        if ($invoice->isNew()) {
            if ($invoice->getPendingTransaction()) {
                return view('subscription.pending', [
                    'invoice' => $invoice,
                ]);

            // go to billing info + payment
            } else {
                // no billing information
                if (!$invoice->hasBillingInformation()) {
                    return redirect()->action('SubscriptionController@billingInformation');
                }

                if ($invoice->isFree()) {
                    return view('subscription.payment', [
                        'invoice' => $invoice,
                    ]);
                } else {
                    return view('subscription.payment', [
                        'invoice' => $invoice,
                    ]);
                }
            }
        }
    }

    public function confirmFree(Request $request)
    {
        // get invoice
        $invoice = $request->user()->customer->invoices()->where('uid', '=', $request->invoice_uid)->first();

        if (!$invoice->isFree()) {
            throw new Exception('Invoice is not free!');
        }

        if ($request->payment_method) {
            $request->user()->customer->updatePaymentMethod([
                'method' => $request->payment_method,
            ]);
        }

        $invoice->confirmWithoutPayment();

        $request->session()->flash('alert-success', trans('messages.invoice.confirmed'));

        return redirect()->action('SubscriptionController@index');
    }

    public function cancelInvoice(Request $request, $uid)
    {
        $invoice = Invoice::findByUid($uid);

        if (!$request->user()->customer->can('delete', $invoice)) {
            return $this->notAuthorized();
        }

        $invoice->cancel();

        // Redirect to my subscription page
        $request->session()->flash('alert-success', trans('messages.invoice.cancelled'));

        return redirect()->action('SubscriptionController@index');
    }

    public function checkout(Request $request)
    {
        $customer = $request->user()->customer;
        $subscription = $customer->subscription;
        $invoice = $subscription->getUnpaidInvoice();

        $request->user()->customer->updatePaymentMethod([
            'method' => $request->payment_method,
        ]);

        // redirect to service checkout
        return redirect()->away($customer->getPreferredPaymentGateway()->getCheckoutUrl($invoice));
    }

    public function billingInformation(Request $request)
    {
        $customer = $request->user()->customer;
        $subscription = $customer->subscription;
        $invoice = $subscription->getUnpaidInvoice();
        $billingAddress = $customer->getDefaultBillingAddress();

        // Save posted data
        if ($request->isMethod('post')) {
            $validator = $invoice->updateBillingInformation($request->all());

            // redirect if fails
            if ($validator->fails()) {
                return response()->view('subscription.billingInformation', [
                    'invoice' => $invoice,
                    'billingAddress' => $billingAddress,
                    'errors' => $validator->errors(),
                ], 400);
            }

            // update current billing information
            $customer->updateBillingInformationFromInvoice($invoice);

            $request->session()->flash('alert-success', trans('messages.billing_address.updated'));

            // return to subscription
            return redirect()->action('SubscriptionController@payment', [
                'invoice_uid' => $invoice->uid,
            ]);
        }

        return view('subscription.billingInformation', [
            'invoice' => $invoice,
            'billingAddress' => $billingAddress,
        ]);
    }

    /**
     * Change plan.
     *
     * @param Request $request
     * @return Response
     **/
    public function changePlan(Request $request)
    {
        $customer = $request->user()->customer;
        $subscription = $customer->subscription;
        $gateway = $customer->getPreferredPaymentGateway();
        $plans = Plan::getAvailablePlans();

        // Authorization
        if (!$request->user()->customer->can('changePlan', $subscription)) {
            return $this->notAuthorized();
        }

        //
        if ($request->isMethod('post')) {
            $newPlan = Plan::findByUid($request->plan_uid);

            try {
                // set invoice as pending
                $changePlanInvoice = $subscription->createChangePlanInvoice($newPlan);
            } catch (Exception $e) {
                $request->session()->flash('alert-error', $e->getMessage());

                return redirect()->action('SubscriptionController@index');
            }

            // return to subscription
            return redirect()->action('SubscriptionController@payment', [
                'invoice_uid' => $changePlanInvoice->uid,
            ]);
        }

        return view('subscription.change_plan', [
            'subscription' => $subscription,
            'gateway' => $gateway,
            'plans' => $plans,
        ]);
    }

    /**
     * Cancel subscription at the end of current period.
     *
     * @param Request $request
     * @return Response
     */
    public function cancel(Request $request)
    {
        if (isSiteDemo()) {
            return response()->json(['message' => trans('messages.operation_not_allowed_in_demo')], 404);
        }

        $customer = $request->user()->customer;
        $subscription = $customer->subscription;

        if ($request->user()->customer->can('cancel', $subscription)) {
            $subscription->cancel();
        }

        // Redirect to my subscription page
        $request->session()->flash('alert-success', trans('messages.subscription.cancelled'));

        return redirect()->action('SubscriptionController@index');
    }

    /**
     * Cancel subscription at the end of current period.
     *
     * @param Request $request
     * @return Response
     */
    public function resume(Request $request)
    {
        $customer = $request->user()->customer;
        $subscription = $customer->subscription;

        if ($request->user()->customer->can('resume', $subscription)) {
            $subscription->resume();
        }

        // Redirect to my subscription page
        $request->session()->flash('alert-success', trans('messages.subscription.resumed'));

        return redirect()->action('SubscriptionController@index');
    }

    /**
     * Cancel now subscription at the end of current period.
     *
     * @param Request $request
     * @return Response
     */
    public function cancelNow(Request $request)
    {
        if (isSiteDemo()) {
            return response()->json(['message' => trans('messages.operation_not_allowed_in_demo')], 404);
        }

        $customer = $request->user()->customer;
        $subscription = $customer->subscription;

        if ($request->user()->customer->can('cancelNow', $subscription)) {
            $subscription->cancelNow();
        }

        // Redirect to my subscription page
        $request->session()->flash('alert-success', trans('messages.subscription.cancelled_now'));

        return redirect()->action('SubscriptionController@index');
    }

    public function orderBox(Request $request)
    {
        $customer = $request->user()->customer;
        $subscription = $customer->subscription;

        // choose a plan
        if ($request->plan_uid) {
            $plan = Plan::findByUid($request->plan_uid);

            return view('subscription.orderBox', [
                'subscription' => $subscription,
                'bill' => [
                    'title' => trans('messages.subscription.your_order'),
                    'description' => trans('messages.subscription.your_order.desc', [
                        'plan' => $plan->name,
                    ]),
                    'bill' => [
                        [
                            'title' => $plan->name,
                            'description' => view('plans._bill_desc', ['plan' => $plan]),
                            'price' => format_price($plan->price, $plan->currency->format),
                            'tax' => format_price($plan->getTax(), $plan->currency->format),
                            'discount' => format_price(0, $plan->currency->format),
                        ],
                    ],
                    'charge_info' => trans('messages.bill.charge_now'),
                    'total' => format_price($plan->total(), $plan->currency->format),
                    'pending' => false,
                    'invoice_uid' => '',
                    'type' => Invoice::TYPE_NEW_SUBSCRIPTION,
                    'plan' => $plan,
                ],
            ]);
        } // choose a plan
        elseif ($subscription) {
            $invoice = $subscription->getUnpaidInvoice();

            return view('subscription.orderBox', [
                'subscription' => $subscription,
                'bill' => $invoice->getBillingInfo(),
                'invoice' => $invoice,
            ]);
        }

        return view('subscription.orderBox', [
            'subscription' => $subscription,
            'bill' => null,
        ]);
    }
}
