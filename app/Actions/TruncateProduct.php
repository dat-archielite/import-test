<?php

declare(strict_types=1);

namespace App\Actions;

use App\Models\Product;

class TruncateProduct
{
    public function __invoke(): void
    {
        Product::truncate();
    }
}
