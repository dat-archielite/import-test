<?php

declare(strict_types=1);

namespace App\ValueObjects;

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

    public function toArray(): array
    {
        return [
            'name' => $this->name,
            'sku' => $this->sku,
            'description' => $this->description,
            'price' => $this->price,
            'stock' => $this->stock,
            'type' => $this->type,
            'vendor' => $this->vendor,
            'status' => $this->status,
            'created_at' => $this->createdAt,
        ];
    }
}
