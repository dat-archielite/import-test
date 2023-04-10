<?php

use App\Http\Controllers\FilePondController;
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

Route::prefix('filepond')
    ->name('filepond.')
    ->controller(FilePondController::class)
    ->group(function () {
        Route::post('process', 'process')->name('process');
        Route::patch('process', 'chunk')->name('chunk');
        Route::delete('process', 'revert')->name('revert');
    });
