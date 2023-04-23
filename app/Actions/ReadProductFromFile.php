<?php

declare(strict_types=1);

namespace App\Actions;

use App\Enums\ProductStatus;
use App\ValueObjects\ProductData;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;
use Illuminate\Validation\ValidationException;
use Rap2hpoutre\FastExcel\Facades\FastExcel;

class ReadProductFromFile
{
    public function __invoke(string $filePath): Collection
    {
        $collection = FastExcel::import($filePath, function (array $row) {
            $row['Status'] = strtolower($row['Status'] ?? '');

            $validator = Validator::make($row, [
                'Name' => ['required', 'string', 'max:255'],
                'SKU' => ['required', 'string', 'max:255'],
                'Description' => ['nullable', 'string', 'max:500'],
                'Price' => ['required', 'numeric', 'min:0'],
                'Stock' => ['required', 'integer', 'min:0'],
                'Status' => ['required', 'string', Rule::enum(ProductStatus::class)],
                'Type' => ['nullable', 'string', 'max:255'],
                'Vendor' => ['nullable', 'string', 'max:255'],
                'Created At' => ['required', 'date'],
            ]);

            if ($validator->fails()) {
                throw new ValidationException($validator);
            }

            $data = $validator->validated();

            $product = new ProductData(
                name: $data['Name'],
                sku: $data['SKU'],
                description: $data['Description'],
                price: (float) $data['Price'],
                stock: (int) $data['Stock'],
                type: $data['Type'],
                vendor: $data['Vendor'],
                status: $data['Status'],
                createdAt: $data['Created At'],
            );

            return $product->toArray();
        });

        Storage::delete($filePath);

        return $collection;
    }
}
