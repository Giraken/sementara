<?php

namespace App\Library\Services;

use App\Models\Product;

class ProductService
{
    public function getAll(): array
    {
        return Product::get();
    }
}
