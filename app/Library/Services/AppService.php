<?php

namespace App\Library\Services;

class AppService
{
    public function getAll(): array
    {
        return user()->apps;
    }
}
