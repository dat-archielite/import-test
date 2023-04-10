<?php

declare(strict_types=1);

namespace App\Models;

use App\Enums\ProductStatus;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    protected $fillable = [
        'name',
        'sku',
        'price',
        'stock',
        'type',
        'vendor',
        'description',
        'status',
    ];

    protected $casts = [
        'price' => 'float',
        'stock' => 'int',
        'status' => ProductStatus::class,
    ];
}
