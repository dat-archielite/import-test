<?php

declare(strict_types=1);

namespace App\Actions;

use App\ValueObjects\ProductData;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Storage;
use Rap2hpoutre\FastExcel\Facades\FastExcel;

class ReadProductFromFile
{
    public function __invoke(string $filePath): Collection
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
