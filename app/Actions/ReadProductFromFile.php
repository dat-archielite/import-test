<?php

declare(strict_types=1);

namespace App\Actions;

use App\ValueObjects\ProductData;
use App\Enums\ProductStatus;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;
use Rap2hpoutre\FastExcel\Facades\FastExcel;

class ReadProductFromFile
{
    public function handle(string $filePath): Collection
    {
        $collection = FastExcel::import($filePath, function (array $row) {
            $product = new ProductData(
                name: $row['Name'],
                sku: $row['SKU'],
                description: $row['Description'],
                price: (float) $row['Price'],
                stock: (int) $row['Stock'],
                type: $row['Type'],
                vendor: $row['Vendor'],
                status: $row['Status'],
                createdAt: $row['Created At'],
            );

            $validator = Validator::make($product->toArray(), [
                'name' => ['required', 'string', 'max:255'],
                'sku' => ['required', 'string', 'max:255'],
                'description' => ['nullable', 'string', 'max:500'],
                'price' => ['required', 'numeric', 'min:0'],
                'stock' => ['required', 'integer', 'min:0'],
                'type' => ['nullable', 'string', 'max:255'],
                'vendor' => ['nullable', 'string', 'max:255'],
                'status' => ['required', 'string', Rule::enum(ProductStatus::class)],
                'created_at' => ['required', 'date_format:Y-m-d H:i:s'],
            ]);

            if ($validator->fails()) {
                return null;
            }

            return $product->toArray();
        });

        Storage::delete($filePath);

        return $collection;
    }
}
