<?php

use App\Http\Controllers\Api\v1\RaffleController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::get('v1/me', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');

Route::prefix('v1')->group(function () {
    Route::apiResource('raffles', RaffleController::class);
    Route::get('raffles/{raffle}/participants', [RaffleController::class, 'getParticipants']);
    Route::post('raffles/{raffle}/participants', [RaffleController::class, 'storeParticipants']);
    Route::get('raffles/{raffle}/prizes', [RaffleController::class, 'getPrizes']);
    Route::get('raffles/{raffle}/criterias', [RaffleController::class, 'getCriterias']);
});
Route::get('raffles/{raffle}/criterias', [RaffleController::class, 'getCriterias']);
