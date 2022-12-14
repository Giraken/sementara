<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Customer;
use App\Models\MailList;
use App\Models\Plan;
use App\Models\User;
use Auth;
use Illuminate\Http\Request;
use Response;
use Validator;

/**
 * /api/v1/customers - API controller for managing customers.
 */
class CustomerController extends Controller
{
    public function index()
    {
        $user = Auth::guard('api')->user();

        $customers = MailList::getAll()
            ->get();

        return Response::json($customers, 200);
    }

    /**
     * Create new customer.
     *
     * POST /api/v1/customers/store
     *
     * @param Request $request All customer information.
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        // Get current user
        $current_user = Auth::guard('api')->user();
        $customer = Customer::newCustomer();
        $user = new User();

        // authorize
        if (!$current_user->can('create', $customer)) {
            return Response::json(['status' => 0, 'message' => 'Unauthorized'], 401);
        }

        // save posted data
        if ($request->isMethod('post')) {
            $rules = $user->apiRules();

            $validator = Validator::make($request->all(), $rules);
            if ($validator->fails()) {
                return response()->json($validator->messages(), 403);
            }

            // Create user account for customer
            $user = new User();
            $user->email = $request->email;
            $user->activated = true;
            // Update password
            if (!empty($request->password)) {
                $user->password = bcrypt($request->password);
            }
            $user->save();

            // Save current user info
            $customer->admin_id = $current_user->admin->id;
            $customer->fill($request->all());
            $customer->status = 'active';

            if ($customer->save()) {
                $user->customer_id = $customer->id;
                $user->save();
                // Upload and save image
                if ($request->hasFile('image')) {
                    if ($request->file('image')->isValid()) {
                        $user->uploadProfileImage($request->file('image'));
                    }
                }

                // Remove image
                if ($request->_remove_image == 'true') {
                    $user->removeProfileImage();
                }

                return Response::json([
                    'status' => 1,
                    'message' => trans('messages.customer.created'),
                    'customer_uid' => $customer->uid,
                    'api_token' => $customer->user->api_token,
                ], 200);
            }
        }
    }

    /**
     * Update customer.
     *
     * PATCH /api/v1/customers
     *
     * @param Request $request All customer information.
     * @param mixed $uid
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $uid)
    {
        // Get current user
        $current_user = Auth::guard('api')->user();
        $customer = Customer::findByUid($uid);

        // check if item exists
        if (!is_object($customer)) {
            return Response::json(['status' => 0, 'message' => 'Customer not found'], 404);
        }

        // authorize
        if (!$current_user->can('update', $customer)) {
            return Response::json(['status' => 0, 'message' => 'Unauthorized'], 401);
        }

        // save posted data
        if ($request->isMethod('patch')) {
            // Prenvent save from demo mod
            $user = $customer->user;
            $user->fill($request->all());

            if ($this->isDemoMode()) {
                return view('somethingWentWrong', ['message' => trans('messages.operation_not_allowed_in_demo')]);
            }

            $rules = $user->apiUpdateRules($request);

            $validator = Validator::make($request->all(), $rules);

            if ($validator->fails()) {
                return response()->json($validator->messages(), 403);
            }

            // Update password
            if (!empty($request->password)) {
                $user->password = bcrypt($request->password);
            }
            $user->save();

            // Save current user info
            $customer->fill($request->all());
            $customer->save();

            // Upload and save image
            if ($request->hasFile('image')) {
                if ($request->file('image')->isValid()) {
                    $user->uploadProfileImage($request->file('image'));
                }
            }

            // Remove image
            if ($request->_remove_image == 'true') {
                $user->removeProfileImage();
            }

            return Response::json([
                'status' => 1,
                'message' => trans('messages.customer.updated'),
                'customer_uid' => $customer->uid,
            ], 200);
        }
    }

    /**
     * Display the specified customer information.
     *
     * GET /api/v1/customers/{uid}
     *
     * @param int $id customer's uid
     * @param mixed $uid
     * @return \Illuminate\Http\Response
     */
    public function show($uid)
    {
        $user = Auth::guard('api')->user();

        $customer = Customer::findByUid($uid);

        // check if item exists
        if (!is_object($customer)) {
            return Response::json(['message' => 'Customer not found'], 404);
        }

        // authorize
        if (!$user->can('read', $customer)) {
            return Response::json(['message' => 'Unauthorized'], 401);
        }

        // Customer info
        $result = [
            'uid' => $customer->uid,
            'first_name' => $user->first_name,
            'last_name' => $user->last_name,
            'timezone' => $customer->timezone,
            'status' => $customer->status,
            'options' => $customer->getOptions(),
            'current_period_ends_at' => $customer->getCurrentPeriodEndsAt(),
        ];

        // Customer contact
        $contact = $customer->contact;
        if (is_object($contact)) {
            $result['contact'] = [
                'first_name' => $contact->first_name,
                'last_name' => $contact->last_name,
                'company' => $contact->company,
                'address_1' => $contact->address_1,
                'address_2' => $contact->address_2,
                'country' => $contact->countryName(),
                'state' => $contact->state,
                'city' => $contact->city,
                'zip' => $contact->zip,
                'phone' => $contact->phone,
                'url' => $contact->url,
                'email' => $contact->email,
            ];
        }

        // Current subscription
        $subscription = $customer->getCurrentSubscription();
        if (is_object($subscription)) {
            $result['current_subscription'] = [
                'uid' => $subscription->uid,
                'plan_name' => $subscription->plan_name,
                'price' => $subscription->price,
                'currency_code' => $subscription->currency_code,
                'start_at' => $subscription->start_at,
                'end_at' => $subscription->end_at,
                'status' => $subscription->status,
            ];
        }

        return Response::json(['customer' => $result], 200);
    }

    /**
     * Enable customer.
     *
     * PATCH /api/v1/customers/{uid}
     *
     * @param int $id customer's uid
     * @param mixed $uid
     * @return \Illuminate\Http\Response
     */
    public function enable($uid)
    {
        $user = Auth::guard('api')->user();

        $customer = Customer::findByUid($uid);

        // check if item exists
        if (!is_object($customer)) {
            return Response::json(['status' => 0, 'message' => 'Customer not found'], 404);
        }

        // authorize
        if (!$user->can('enable', $customer)) {
            return Response::json(['status' => 0, 'message' => 'Unauthorized'], 401);
        }

        $customer->enable();

        return Response::json([
            'status' => 1,
            'message' => trans('messages.customer.enabled'),
            'customer_uid' => $customer->uid,
        ], 200);
    }

    /**
     * Disable customer.
     *
     * PATCH /api/v1/customers/{uid}
     *
     * @param int $id customer's uid
     * @param mixed $uid
     * @return \Illuminate\Http\Response
     */
    public function disable($uid)
    {
        $user = Auth::guard('api')->user();

        $customer = Customer::findByUid($uid);

        // check if item exists
        if (!is_object($customer)) {
            return Response::json(['status' => 0, 'message' => 'Customer not found'], 404);
        }

        // authorize
        if (!$user->can('disable', $customer)) {
            return Response::json(['status' => 0, 'message' => 'Unauthorized'], 401);
        }

        $customer->disable();

        return Response::json([
            'status' => 1,
            'message' => trans('messages.customer.disabled'),
            'customer_uid' => $customer->uid,
        ], 200);
    }

    /**
     * Assign plan to customer.
     *
     * @param Request $request
     * @param mixed $uid
     * @param mixed $plan_uid
     * @return \Illuminate\Http\Response
     */
    public function assignPlan(Request $request, $uid, $plan_uid)
    {
        $user = Auth::guard('api')->user();
        $customer = Customer::findByUid($uid);

        // check if item exists
        if (!is_object($customer)) {
            return Response::json(['status' => 0, 'message' => 'Customer not found'], 404);
        }

        // authorize
        if (!$user->can('assignPlan', $customer)) {
            return Response::json(['status' => 0, 'message' => 'Unauthorized'], 401);
        }

        $plan = Plan::findByUid($plan_uid);

        // check if item exists
        if (!is_object($plan)) {
            return Response::json(['status' => 0, 'message' => 'Can not find plan with id: ' . $plan_uid], 404);
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

    /**
     * Generate one time token.
     *
     * PATCH /api/v1/customers/{uid}/login-token
     *
     * @param int $id customer's uid
     * @return \Illuminate\Http\Response
     */
    public function loginToken(Request $request)
    {
        $user = Auth::guard('api')->user();

        // if for another customer
        if ($request->customer_uid) {
            $customer = Customer::findByUid($request->customer_uid);

            // authorize
            if (!$user->can('loginAs', $customer)) {
                return Response::json(['status' => 0, 'message' => 'Unauthorized'], 401);
            }

            $user = $customer->user;
        }

        $user->generateOneTimeToken();

        echo json_encode([
            'token' => $user->one_time_api_token,
            'url' => action('Controller@tokenLogin', ['token' => $user->one_time_api_token]),
        ], JSON_UNESCAPED_SLASHES);
    }
}
