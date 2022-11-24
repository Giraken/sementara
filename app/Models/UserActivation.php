<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class UserActivation extends Model
{
    /**
     * Get user activation token.
     *
     * @return string
     */
    public static function getToken()
    {
        return hash_hmac('sha256', str_random(40), config('app.key'));
    }

    /**
     * User.
     *
     * @return string
     */
    public function user()
    {
        return $this->belongsTo('App\Models\User');
    }
}
