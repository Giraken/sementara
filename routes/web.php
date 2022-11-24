<?php

use App\Http\Controllers\BillingController;
use App\Http\Controllers\PaymentController;
use App\Http\Controllers\PlanController;
use App\Http\Controllers\SubscriptionController;
use App\Http\Middleware\VerifyCsrfToken;
use Illuminate\Foundation\Application;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

// VUE APP
Route::middleware([
    'auth',
    config('jetstream.auth_session'),
    'verified',
])->group(function () {
    Route::get('/', function () {
        return Inertia::render('Dashboard', [
            'canLogin' => Route::has('login'),
            'canRegister' => Route::has('register'),
            'laravelVersion' => Application::VERSION,
            'phpVersion' => PHP_VERSION,
        ]);
    })->name('dashboard');
});

Route::get('/custom/logger', [PlanController::class, 'customLogger']);

Route::withoutMiddleware([VerifyCsrfToken::class])->group(function () {
    Route::post('/paypal/subscription/payment/completed', [PaymentController::class, 'handlePaypalRecurringCharge']);
    Route::post('/paypal/subscription/payment/failed', [PaymentController::class, 'handlePaypalSubscriptionPaymentFailed']);
    Route::post('/paypal/subscription/cancelled', [PaymentController::class, 'handlePaypalCancelledSubscription']);

    Route::post('/midtrans/payments/notifications', [PaymentController::class, 'handleMidtransRecurringCharge']);
    // Route::post('/midtrans/subscriptions/notifications', function (Request $request) {
    //     error_log('Midtrans Subscription Notification: ' . json_encode($request->all(), JSON_PRETTY_PRINT));
    //     $notif = new \Midtrans\Notification();
    //     $notif->getResponse();
    //     return response(null, 200);
    // });
});

Route::middleware(['auth'])->group(function () {
    Route::get('/billings', [BillingController::class, 'index'])->name('billings.index');

    Route::get('/plans', [PlanController::class, 'index'])->name('plans.index');
    Route::get('/plans/{plan_id}/checkout', [PlanController::class, 'checkout'])->name('plans.checkout');

    // Initialization for subscription payment
    Route::post('/paypal/subscription', [PaymentController::class, 'storePaypalSubscription'])->name("paypal.subscription.store");
    Route::post('/paypal/subscription/cancel', [PaymentController::class, 'cancelPaypalSubscription'])->name("paypal.subscription.cancel");

    Route::post('/midtrans/subscription', [PaymentController::class, 'storeMidtransSubscription'])->name("midtrans.subscription.store");
    Route::post('/midtrans/subscription/cancel', [PaymentController::class, 'cancelMidtransSubscription'])->name("midtrans.subscription.cancel");

    Route::get('/subscriptions', [SubscriptionController::class, 'index'])->name('subscriptions.index');
    Route::get('/subscriptions/favorites', [SubscriptionController::class, 'favorites'])->name('subscriptions.favorites');
    Route::get('/subscriptions/{subscription_id}', null)->name('subscriptions.show');
    Route::put('/subscriptions/{subscription_id}/favorites/{action}', [SubscriptionController::class, 'updateFavorite'])->name('subscriptions.favorites.update');

    Route::get('/subscriptions/{subscription_id}', [SubscriptionController::class, 'show'])->name('subscriptions.show');
    Route::post('/subscriptions/{subscription_id}/members', [SubscriptionController::class, 'storeBulkMemberships'])->name('subscriptions.members.store_bulk');
    Route::delete('/subscriptions/{subscription_id}/members', [SubscriptionController::class, 'destroyBulkMemberships'])->name('subscriptions.members.destroy_bulk');
});

// Google login
Route::get('login/google', [App\Http\Controllers\OauthController::class, 'redirectToGoogle'])->name('login.google');
Route::get('login/google/callback', [App\Http\Controllers\OauthController::class, 'googleCallback']);

// Facebook login
Route::get('login/facebook', [App\Http\Controllers\OauthController::class, 'redirectToFacebook'])->name('login.facebook');
Route::get('login/facebook/callback', [App\Http\Controllers\OauthController::class, 'facebookCallback']);

// LARAVEL APP

//Auth::routes();
//Language Translation
//Route::get('index/{locale}', [App\Http\Controllers\HomeController::class, 'lang']);

//Route::get('{any}', [App\Http\Controllers\HomeController::class, 'index'])->name('index']);

//Route::middleware([
//    'auth:sanctum',
//    config('jetstream.auth_session'),
//    'verified'
//])->group(function () {
//    Route::get('/dashboard', function () {
//        return view('dashboard']);
//    })->name('dashboard']);
//});

// For visitor with Web UI, loading the right app language
//Route::group(['middleware' => ['unauthenticated']], function () {
//    Route::get('/login/token/{token}', [AuthController::class, 'tokenLogin']);
//
//    Route::get('/validate-token/{api_token}', [AuthController::class, 'validateToken']);
//    Route::get('user/activate/{token}', [UserController::class, 'activate']);
//    Route::get('/disabled', [AuthController::class, 'userDisabled']);
//    Route::get('/offline', [AuthController::class, 'offline']);
//    Route::get('/not-authorized', [AuthController::class, 'notAuthorized']);
//    Route::get('/autologin/{api_token}', [AuthController::class, 'autoLogin']);
//
//    // User resend activation email
//    Route::get('users/resend-activation-email', [UserController::class, 'resendActivationEmail']);
//
//    // Plan
//    Route::get('plans/select2', [PlanController::class, 'select2']);
//
//    // Customer registration
//    Route::post('users/register', [UserController::class, 'register']);
//    Route::get('users/register', [UserController::class, 'register']);
//
//    // Store
//    Route::get('store/guest', [StoreController::class, 'guest'])->name('store.guest');
//});

// Without authentication
//Route::group(['middleware' => ['unauthenticated']], function () {
// Also allow GET logout (the logout route generated by Route::auth() is POST)
//    Route::get('logout', 'Auth\LoginController@logout')->name('logout');   // use GET for logout, keep compatible with 5.2
//});

//Route::group(['middleware' => ['auth']], function () {
//    // get files from download
//    Route::get('/download/{name?}', [ function ($name) {
//        $path = storage_path('app/download/' . $name);
//        if (\File::exists($path)) {
//            return response()->download($path);
//        } else {
//            abort(404);
//        }
//    }])->where('name', '.+')->name('download']);
//});

// CUSTOMER
//Route::group(['middleware' => ['auth', 'verified']], function () {
//    Route::get('/', [App\Http\Controllers\HomeController::class, 'root'])->name('dashboard');
//
//    // Update User Details
//    Route::post('/update-profile/{id}', [App\Http\Controllers\HomeController::class, 'updateProfile'])->name('updateProfile');
//    Route::post('/update-password/{id}', [App\Http\Controllers\HomeController::class, 'updatePassword'])->name('updatePassword');
//
//    // Store
//    Route::get('store', [AppController::class, 'list'])->name('store');
//    Route::get('store/select-app', [AppController::class, 'selectApp'])->name('store.select-app');
//    Route::get('store/select-plan/{product_id}', [AppController::class, 'selectPlan'])->name('store.select-plan');
//    Route::get('store/create/{product_id}/{plan_id}', [AppController::class, 'create'])->name('store.create');
//
//    // Apps
//    Route::get('apps', [AppController::class, 'index'])->name('apps.my');
//    Route::get('apps/{app_id}', [AppController::class, 'show'])->name('apps.show');
//
//    // Teams
//    Route::get('teams', [TeamController::class, 'show'])->name('teams.my');
//
//    // New subscription
//    Route::get('account/subscription/select-plan', [SubscriptionController::class, 'selectPlan']);
//    Route::get('account/subscription/order-box', [SubscriptionController::class, 'orderBox']);
//    Route::match(['get', 'post'], 'account/subscription/change-plan', [SubscriptionController::class, 'changePlan']);
//    Route::post('account/subscription/resume', [SubscriptionController::class, 'resume']);
//    Route::post('account/subscription/cancel', [SubscriptionController::class, 'cancel']);
//    Route::post('account/subscription/invoice/{invoice_uid}/confirm-free', [SubscriptionController::class, 'confirmFree']);
//    Route::match(['get', 'post'], 'account/subscription/billing-information', [SubscriptionController::class, 'billingInformation']);
//    Route::post('account/subscription/checkout', [SubscriptionController::class, 'checkout']);
//    Route::post('account/subscription/cancel-now', [SubscriptionController::class, 'cancelNow']);
//    Route::post('account/subscription/invoice/{invoice_uid}/cancel', [SubscriptionController::class, 'cancelInvoice']);
//    Route::post('account/subscription/invoice/{invoice_uid}/confirm', [SubscriptionController::class, 'confirmFree']);
//    Route::get('account/subscription/payment/{invoice_uid}', [SubscriptionController::class, 'payment']);
//    Route::post('account/subscription/init', [SubscriptionController::class, 'init']);
//    Route::get('account/subscription', [SubscriptionController::class, 'index']);
//
//    // Customer profile/information
//    Route::post('account/change-theme-mode', [AccountController::class, 'changeThemeMode']);
//    Route::get('account/save-auto-theme-mode', [AccountController::class, 'saveAutoThemeMode']);
//    Route::get('account/activity', [AccountController::class, 'activity']);
//    Route::match(['get', 'post'], 'account/wizard/menu-layout', [AccountController::class, 'wizardMenuLayout']);
//    Route::match(['get', 'post'], 'account/wizard/color-scheme', [AccountController::class, 'wizardColorScheme']);
//    Route::get('account/leftbar/state', [AccountController::class, 'leftbarState']);
//    Route::post('account/payment/remove', [AccountController::class, 'removePaymentMethod']);
//    Route::match(['get', 'post'], 'account/payment/edit', [AccountController::class, 'editPaymentMethod']);
//    Route::get('account/profile', [AccountController::class, 'profile'])->name("account.profile");
//    Route::post('account/profile', [AccountController::class, 'profile']);
//    Route::get('account/contact', [AccountController::class, 'contact']);
//    Route::post('account/contact', [AccountController::class, 'contact']);
//    Route::get('account/logs', [AccountController::class, 'logs']);
//    Route::get('account/logs/listing', [AccountController::class, 'logsListing']);
//    Route::get('account/quota_log_2', [AccountController::class, 'quotaLog2']);
//    Route::get('account/quota_log', [AccountController::class, 'quotaLog']);
//    Route::get('account/billing', [AccountController::class, 'billing'])->name("account.billing");
//    Route::match(['get', 'post'], 'account/billing/edit', [AccountController::class, 'editBillingAddress']);
//});
