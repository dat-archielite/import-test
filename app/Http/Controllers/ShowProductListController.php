<?php

declare(strict_types=1);

namespace App\Http\Controllers;

use App\Http\Resources\ProductCollection;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\ResourceCollection;

class ShowProductListController extends Controller
{
    public function __invoke(Request $request): ResourceCollection
    {
        $products = Product::query()->paginate()->onEachSide(2);

        return new ProductCollection($products);
    }
}
