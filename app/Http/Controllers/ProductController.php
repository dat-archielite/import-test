<?php

declare(strict_types=1);

namespace App\Http\Controllers;

use App\Http\Resources\ProductCollection;
use App\Http\Resources\ProductResource;
use App\Models\Product;
use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Http\Resources\Json\ResourceCollection;

class ProductController extends Controller
{
    public function index(): ResourceCollection
    {
        $products = Product::query()
            ->latest('id')
            ->paginate()
            ->onEachSide(2);

        return new ProductCollection($products);
    }

    public function show(Product $product): JsonResource
    {
        return new ProductResource($product);
    }
}
