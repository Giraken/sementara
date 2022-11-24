<?php

namespace App\Library\Facades;

use App\Library\BillingManager;
use Illuminate\Support\Facades\Facade;

class Billing extends Facade
{
    protected static function getFacadeAccessor()
    {
        return BillingManager::class;
    }
}
