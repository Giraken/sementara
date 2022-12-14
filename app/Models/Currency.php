<?php

namespace App\Models;

use App\Library\Traits\HasUUID;
use Illuminate\Database\Eloquent\Model;

class Currency extends Model
{
    use HasUUID;

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = ['admin_id'];

    /**
     * Items per page.
     *
     * @var array
     */
    public static $itemsPerPage = 25;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'code', 'format',
    ];

    public function paymentServiceProviders()
    {
        return $this->belongsToMany(PaymentServiceProvider::class, 'payment_service_provider_supported_currencies', 'currency_id', 'payment_service_provider_id');
    }

    /**
     * Bootstrap any application services.
     */
    public static function boot()
    {
        parent::boot();

        // Create uid when creating list.
        static::creating(function ($item) {
            $item->uid = uniqid();

            // uppercase for currency code
            $item->code = strtoupper($item->code);
        });

        static::updating(function ($item) {
            // uppercase for currency code
            $item->code = strtoupper($item->code);
        });
    }

    /**
     * Search items.
     *
     * @param mixed $request
     * @return collect
     */
    public static function search($request)
    {
        $query = self::filter($request);

        if (!empty($request->sort_order)) {
            $query = $query->orderBy($request->sort_order, $request->sort_direction);
        }

        return $query;
    }

    /**
     * Filter items.
     *
     * @param mixed $request
     * @return collect
     */
    public static function filter($request)
    {
        $query = self::select('currencies.*');

        // Keyword
        if (!empty(trim($request->keyword))) {
            foreach (explode(' ', trim($request->keyword)) as $keyword) {
                $query = $query->where(function ($q) use ($keyword) {
                    $q->orwhere('currencies.name', 'like', '%' . $keyword . '%')
                        ->orWhere('currencies.code', 'like', '%' . $keyword . '%');
                });
            }
        }

        if (!empty($request->admin_id)) {
            $query = $query->where('currencies.admin_id', '=', $request->admin_id);
        }

        return $query;
    }

    /**
     * Get customer select2 select options.
     *
     * @param mixed $request
     * @return array
     */
    public static function select2($request)
    {
        $data = ['items' => [], 'more' => true];

        $query = self::getAll();
        if (isset($request->q)) {
            $keyword = $request->q;
            $query = $query->where(function ($q) use ($keyword) {
                $q->orwhere('currencies.name', 'like', '%' . $keyword . '%')
                    ->orwhere('currencies.code', 'like', '%' . $keyword . '%');
            });
        }

        // Read all check
        if (!$request->user()->admin->can('readAll', new Currency())) {
            $query = $query->where('currencies.admin_id', '=', $request->user()->admin->id);
        }

        foreach ($query->limit(20)->get() as $currency) {
            $data['items'][] = ['id' => $currency->id, 'text' => $currency->displayName()];
        }

        return json_encode($data);
    }

    /**
     * Get all items.
     *
     * @return collect
     */
    public static function getAll()
    {
        return self::select('*');
    }

    /**
     * The rules for validation.
     *
     * @var array
     */
    public function rules()
    {
        return [
            'name' => 'required',
            'code' => 'required|alpha|min:2',
            'format' => 'required|substring:{PRICE}',
        ];
    }

    /**
     * Associations.
     *
     * @var object|collect
     */
    public function admin()
    {
        return $this->belongsTo('App\Models\Admin');
    }

    /**
     * Disable customer.
     *
     * @return bool
     */
    public function disable()
    {
        $this->status = 'inactive';

        return $this->save();
    }

    /**
     * Enable customer.
     *
     * @return bool
     */
    public function enable()
    {
        $this->status = 'active';

        return $this->save();
    }

    /**
     * Display currency name.
     *
     * @return collect
     */
    public function displayName()
    {
        return htmlspecialchars($this->name . ' (' . $this->code . ')');
    }
}
