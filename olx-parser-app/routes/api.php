<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\SubscriptionController;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');

Route::get('/test', function () {
    return response()->json(['message' => 'API is working!']);
});

Route::post('/subscribe', [SubscriptionController::class, 'subscribe']);

Route::get('/check-subscription', [SubscriptionController::class, 'checkSubscription'])->name('subscription.get');

Route::delete('/delete-subscription', [SubscriptionController::class, 'deleteSubscription'])->name('subscription.delete');