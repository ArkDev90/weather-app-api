<?php

use App\Http\Controllers\geoController;
use App\Http\Controllers\weatherController;
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

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

Route::get('weather', [weatherController::class, 'getWeatherCityDetails']);

Route::get('geo', [geoController::class, 'getCityDetails']);

Route::get('places', [geoController::class, 'getNearbyPlaces']);
