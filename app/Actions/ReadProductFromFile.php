<?php

declare(strict_types=1);

namespace App\Actions;

use App\DataObjects\ProductData;
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
            $product = ProductData::fromArray($row);

            $data = [
                'name' => $product->name,
                'sku' => $product->sku,
                'description' => $product->description,
                'price' => $product->price,
                'stock' => $product->stock,
                'type' => $product->type,
                'vendor' => $product->vendor,
                'status' => $product->status,
                'created_at' => $product->createdAt,
            ];

            $validator = Validator::make($data, [
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

            return $data;
        });

        Storage::delete($filePath);

        return $collection;
    }
}
