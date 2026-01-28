<?php

use App\Http\Controllers\LandingPageController;
use App\Models\Order;
use Illuminate\Support\Facades\Route;



// Route::get('/', function () {
//     return view('welcome');
// })->name('home');

// Route::view('dashboard', 'dashboard')
//     ->middleware(['auth', 'verified'])
//     ->name('dashboard');

// print receipt for an order
Route::get('/orders/{order}/receipt', function (Order $order) {
    return view('orders.receipt', compact('order'));
})->middleware('auth')->name('orders.receipt');

// Landing page routes
Route::get('/', [LandingPageController::class, 'index'])->name('landing');
Route::get('/{slug}', [LandingPageController::class, 'index'])->name('landing.barbershop');

require __DIR__.'/settings.php';
