<?php

declare(strict_types=1);

use App\Http\Controllers\FilePondController;
use App\Http\Controllers\ImportProductController;
use App\Http\Controllers\ProductController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::view('/', 'home')->name('home');

Route::prefix('products')->name('products.')->group(function () {
    Route::get('/', [ProductController::class, 'index'])->name('index');
    Route::get('{product}', [ProductController::class, 'show'])->name('show');
    Route::post('import', ImportProductController::class)->name('import');
    Route::delete('truncate', [ProductController::class, 'truncate'])->name('truncate');
});

Route::prefix('filepond')
    ->name('filepond.')
    ->controller(FilePondController::class)
    ->group(function () {
        Route::post('process', 'process')->name('process');
        Route::patch('process', 'chunk')->name('chunk');
        Route::delete('process', 'revert')->name('revert');
    });
