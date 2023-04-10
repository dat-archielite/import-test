<?php

declare(strict_types=1);

namespace App\Http\Controllers;

use App\Actions\ImportProduct;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Rap2hpoutre\FastExcel\Facades\FastExcel;

class ImportProductController extends Controller
{
    public function __invoke(Request $request, ImportProduct $importProduct): JsonResponse
    {
        $serverId = $request->input('serverId');
        $filePath = str_contains($serverId, '.csv') ? $serverId : "$serverId.csv";
        $filePath = storage_path("app/$filePath");

        $collection = FastExcel::import($filePath, function (array $row) {
            return [
                'name' => $row['Name'],
                'sku' => $row['SKU'],
                'description' => $row['Description'],
                'price' => $row['Price'],
                'stock' => $row['Stock'],
                'type' => $row['Type'],
                'vendor' => $row['Vendor'],
                'status' => strtolower($row['Status']),
                'created_at' => $row['Created At'],
            ];
        });

        Storage::delete($filePath);

        $importProduct->handle($collection);

        return response()->json(['message' => __('File imported successfully.')]);
    }
}
