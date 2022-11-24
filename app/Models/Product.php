<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    public const STATUS_INACTIVE = 'inactive';

    public const STATUS_ACTIVE = 'active';

    protected $fillable = [];

    public function plans()
    {
        return $this->hasMany(Plan::class);
    }

    public static function whereAvailableProducts($query = null)
    {
        return $query
            ? $query->where('is_visible', 1)->where('status', self::STATUS_ACTIVE)
            : self::where('is_visible', 1)->where('status', self::STATUS_ACTIVE);
    }
}
