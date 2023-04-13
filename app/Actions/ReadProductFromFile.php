<?php

declare(strict_types=1);

namespace App\Actions;

use App\ValueObjects\ProductData;
use App\Enums\ProductStatus;
use Illuminate\Support\Arr;
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
                status: str($row['Status'])->lower()->toString(),
                createdAt: $row['Created At'],
            );

            return $product->toArray();
        });

        Storage::delete($filePath);

        return $collection;
    }
}
