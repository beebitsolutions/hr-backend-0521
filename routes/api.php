<?php

use App\Http\Controllers\DogController;
use App\Http\Controllers\OwnerController;
use App\Http\Controllers\ParkController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::post('auth/login', function(Request $request) {
    $credentials = $request->only('email', 'password');

    if (Auth::attempt($credentials)) {
        return ['token' => $request->user()->createToken('token')->plainTextToken];
    }
});

Route::post('/tokens/create', function (Request $request) {
    $token = $request->user()->createToken('token');
    return ['token' => $token->plainTextToken];
});

Route::middleware('auth:sanctum')->group(function() {
    Route::get('owners', [OwnerController::class, 'list']);
    Route::post('owners', [OwnerController::class, 'create']);

    Route::get('dogs', [DogController::class, 'index']);
    Route::post('dogs', [DogController::class, 'create']);

    Route::get('parks', [ParkController::class, 'index']);
    Route::post('parks', [ParkController::class, 'create']);
    Route::group(['prefix' => 'parks'], function () {
        Route::get('{park}/owners', [ParkController::class, 'listOwnersWithDogs']);
        Route::post('owners', [ParkController::class, 'addOwnerWithDogs']);
        Route::delete('owners', [ParkController::class, 'forceOwnersLeave']);
    });
});

