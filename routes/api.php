<?php

use App\Http\Controllers\StripeController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');

Route::get('stripe/checkout', [StripeController::class, 'checkout']);
Route::get('stripe/checkout-session', [StripeController::class, 'session']);
Route::get('stripe/checkout-success', [StripeController::class, 'success'])->name('stripe.success');
Route::get('stripe/checkout-cancel', [StripeController::class, 'cancel'])->name('stripe.cancel');
