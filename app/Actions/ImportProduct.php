<?php

declare(strict_types=1);

namespace App\Actions;

use App\Enums\ProductStatus;
use App\Models\Product;
use Exception;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;

class ImportProduct
{
    public function handle(Collection $collection): void
    {
        DB::transaction(function () use ($collection) {
            $collection->each(function ($row) {
                $validator = Validator::make($row, [
                    'name' => ['required', 'string', 'min:3', 'max:150'],
                    'sku' => ['required', 'string', 'unique:products,sku'],
                    'description' => ['required', 'string'],
                    'price' => ['required', 'numeric'],
                    'stock' => ['required', 'numeric'],
                    'type' => ['nullable', 'string'],
                    'vendor' => ['nullable', 'string'],
                    'status' => ['required', 'string', Rule::enum(ProductStatus::class)],
                    'created_at' => ['nullable', 'date'],
                ]);

                if ($validator->fails()) {
                    throw new Exception($validator->errors()->first());
                }

                Product::insert($row);
            });
        });
    }
}
