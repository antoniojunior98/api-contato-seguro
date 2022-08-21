<?php

use App\Http\Controllers\CityController;
use App\Http\Controllers\CompanyController;
use App\Http\Controllers\StateController;
use App\Http\Controllers\UserController;
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
Route::post('/users', [UserController::class, 'index']);
Route::get('/user/{user}/show', [UserController::class, 'show']);
Route::post('/user/store', [UserController::class, 'store']);
Route::put('/user/{user}/update', [UserController::class, 'update']);
Route::delete('/user/{user}/delete', [UserController::class, 'destroy']);

Route::get('/company', [CompanyController::class, 'index']);
Route::get('/company/{company}/show', [CompanyController::class, 'show']);
Route::get('/company/validate_cnpj', [CompanyController::class, 'validateCnpj']);
Route::post('/company/store', [CompanyController::class, 'store']);
Route::put('/company/{company}/update', [CompanyController::class, 'update']);
Route::delete('/company/{company}/delete', [CompanyController::class, 'destroy']);

Route::get('/state', [StateController::class, 'index']);
Route::post('/state/store', [StateController::class, 'store']);
Route::put('/state/{state}/update', [StateController::class, 'update']);
Route::delete('/state/{state}/delete', [StateController::class, 'destroy']);

Route::get('/city', [CityController::class, 'index']);
Route::get('/city/{city}/show', [CityController::class, 'show']);
Route::post('/city/store', [CityController::class, 'store']);
Route::put('/city/{city}/update', [CityController::class, 'update']);
Route::delete('/city/{city}/delete', [CityController::class, 'destroy']);
