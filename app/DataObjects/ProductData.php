<?php

declare(strict_types=1);

namespace App\DataObjects;

class ProductData
{
    public function __construct(
        public string $name,
        public string $sku,
        public string|null $description,
        public float $price,
        public int $stock,
        public string|null $type,
        public string|null $vendor,
        public string|null $status,
        public string|null $createdAt,
    ) {
    }

    public static function fromArray(array $data): self
    {
        return new self(
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
    }
}
