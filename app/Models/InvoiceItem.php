<?php

namespace App\Models;

use App\Library\Traits\HasUUID;
use Illuminate\Database\Eloquent\Model;

class InvoiceItem extends Model
{
    use HasUUID;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'item_id', 'item_type', 'amount', 'title', 'description', 'vat',
    ];

    /**
     * Invoice.
     */
    public function invoice()
    {
        return $this->belongsTo('App\Models\Invoice');
    }

    /**
     * Total amount.
     *
     * @return void
     */
    public function total()
    {
        return $this->subTotal() + $this->getTax();
    }

    public function subTotal()
    {
        return $this->amount - $this->discount;
    }

    /**
     * Tax amount.
     *
     * @return void
     */
    public function getTax()
    {
        $tax = $this->getTaxPercent();

        return $this->subTotal() * ($tax / 100);
    }

    /**
     * Tax percent.
     *
     * @return void
     */
    public function getTaxPercent()
    {
        if ($this->invoice->billing_country_id) {
            $country = Country::find($this->invoice->billing_country_id);
            $tax = Setting::getTaxByCountry($country);
        } else {
            $tax = Setting::getTaxByCountry(null);
        }

        return $tax;
    }
}
