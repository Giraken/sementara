<?php

namespace App\Library\Traits;

use Str;

trait HasUUID
{
    /**
     * @var string
     */
    public ?string $uuid = null;

    public string $parentFieldName = 'parent_id';

    public static function boot()
    {
        parent::boot();

        static::creating(function ($model) {
            if (is_null($model->getUUID())) {
                $model->uuid = Str::uuid();
            }
        });
    }

    public static function findByUid($uid)
    {
        return self::where('uuid', '=', $uid)->first();
    }

    public function generateUid()
    {
        $this->uuid = Str::uuid();
    }

    public function getUUID(): ?string
    {
        return $this->uuid;
    }
}
