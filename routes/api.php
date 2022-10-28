<?php

use App\Http\Controllers\EquipmentTypeController;
use App\Http\Controllers\EquipmentController;
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

Route::get('/equipment-type', [EquipmentTypeController::class, 'index']);

Route::get('/equipment', [EquipmentController::class, 'index']);
Route::post('/equipment', [EquipmentController::class, 'store']);
Route::get('/equipment/{id}', [EquipmentController::class, 'show']);
Route::put('/equipment/{id}', [EquipmentController::class, 'update']);
Route::delete('/equipment/{id}', [EquipmentController::class, 'destroy']);