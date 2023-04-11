<?php

declare(strict_types=1);

namespace App\Actions;

use App\Models\Product;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\DB;

class ImportProduct
{
    public function handle(Collection $collection): void
    {
        DB::transaction(function () use ($collection) {
            $collection->chunk(10000)->each(function (Collection $chunk) {
                Product::insert($chunk->toArray());
            });
        });
    }
}
