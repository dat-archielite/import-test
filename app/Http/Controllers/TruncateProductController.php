<?php

declare(strict_types=1);

namespace App\Http\Controllers;

use App\Actions\TruncateProduct;
use Illuminate\Http\JsonResponse;

class TruncateProductController extends Controller
{
    public function __invoke(TruncateProduct $truncateProductTable): JsonResponse
    {
        $truncateProductTable->handle();

        return response()->json(['message' => __('Products table truncated')]);
    }
}
