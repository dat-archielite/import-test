<?php

declare(strict_types=1);

namespace App\Http\Controllers;

use App\Actions\ImportProduct;
use App\Actions\ReadProductFromFile;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class ImportProductController extends Controller
{
    public function __invoke(
        Request $request,
        ImportProduct $importProduct,
        ReadProductFromFile $readProductFromFile
    ): JsonResponse {
        $serverId = $request->input('serverId');
        $filePath = str_contains($serverId, '.csv') ? $serverId : "$serverId.csv";
        $filePath = storage_path("app/$filePath");

        $collection = $readProductFromFile($filePath);

        $importProduct($collection);

        return response()->json(['message' => __('File imported successfully.')]);
    }
}
