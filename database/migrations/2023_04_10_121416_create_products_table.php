<?php

declare(strict_types=1);

use App\Enums\ProductStatus;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class () extends Migration {
    public function up(): void
    {
        Schema::create('products', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('sku');
            $table->float('price', 10);
            $table->integer('stock')->default(0);
            $table->string('type')->nullable();
            $table->string('vendor')->nullable();
            $table->string('description', 500)->nullable();
            $table->string('status')->default(ProductStatus::Drafted->value);
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('products');
    }
};
