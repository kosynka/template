<?php

use App\Http\Controllers\Admin\AuthController;
use App\Http\Controllers\Admin\GlazingController;
use App\Http\Controllers\Admin\ColorController;
use App\Http\Controllers\Admin\ExecutorController;
use App\Http\Controllers\Admin\LockController;
use App\Http\Controllers\Admin\OrderController;
use App\Http\Controllers\Admin\ProfileTypeController;
use App\Http\Controllers\Admin\PropertyTypeController;
use App\Http\Controllers\Admin\UserController;
use App\Http\Controllers\Admin\CitiesController;
use App\Http\Controllers\Admin\UrgenciesController;
use App\Http\Controllers\Admin\OfferController;
use App\Http\Controllers\Admin\BusinessTypesController;
use Illuminate\Support\Facades\Route;

Route::prefix('admin')->group(function () {
    Route::get('login', [AuthController::class, 'login']);
    Route::post('signin', [AuthController::class, 'signin']);
    Route::get('logout', [AuthController::class, 'logout']);
    Route::get('edit', [AuthController::class, 'edit']);
    Route::post('update', [AuthController::class, 'update']);
    Route::post('store', [AuthController::class, 'store']);

    Route::group(['middleware' => 'auth'], function () {

        Route::get('/', [OrderController::class, 'index']);
        
        Route::group(['prefix' => 'user'], function () {
            Route::get('', [UserController::class, 'index']);
            Route::get('/delete/{id}', [UserController::class, 'delete']);
            Route::get('/{id}', [UserController::class, 'details'])->name('user.details');
            Route::post('/{id}/update', [UserController::class, 'update']);
        });
        
        Route::group(['prefix' => 'executor'], function () {
            Route::get('', [ExecutorController::class, 'index']);
            Route::post('/store', [ExecutorController::class, 'store']);
            Route::get('/delete/{id}', [ExecutorController::class, 'delete']);
            Route::get('/{id}', [ExecutorController::class, 'details'])->name('executors.details');
            Route::post('/{id}/update', [ExecutorController::class, 'update']);
        });
        
        Route::group(['prefix' => 'offer'], function () {
            Route::get('', [OfferController::class, 'index']);
            Route::get('/{id}', [OfferController::class, 'details'])->name('offers.details');
            Route::post('/{id}/update', [OfferController::class, 'update']);
        });

        Route::group(['prefix' => 'city'], function () {
            Route::get('/', [CitiesController::class, 'index']);
            Route::get('/add', [CitiesController::class, 'add']);
            Route::post('/create', [CitiesController::class, 'create']);
            Route::get('/edit/{id}', [CitiesController::class, 'edit']);
            Route::post('/update/{id}', [CitiesController::class, 'update']);
            Route::get('/delete/{id}', [CitiesController::class, 'delete']);
        });

        Route::group(['prefix' => 'urgency'], function () {
            Route::get('/', [UrgenciesController::class, 'index']);
            Route::get('/add', [UrgenciesController::class, 'add']);
            Route::post('/create', [UrgenciesController::class, 'create']);
            Route::get('/edit/{id}', [UrgenciesController::class, 'edit']);
            Route::post('/update/{id}', [UrgenciesController::class, 'update']);
            Route::get('/delete/{id}', [UrgenciesController::class, 'delete']);
        });

        Route::group(['prefix' => 'business_type'], function () {
            Route::get('/', [BusinessTypesController::class, 'index']);
            Route::get('/add', [BusinessTypesController::class, 'add']);
            Route::post('/create', [BusinessTypesController::class, 'create']);
            Route::get('/edit/{id}', [BusinessTypesController::class, 'edit']);
            Route::post('/update/{id}', [BusinessTypesController::class, 'update']);
            Route::get('/delete/{id}', [BusinessTypesController::class, 'delete']);
        });

        Route::post('/update/{id}', [OrderController::class, 'updateOrder']);
        Route::get('/accept/offer/{id}', [OrderController::class, 'acceptOffer']);
        Route::get('/decline/offer/{id}', [OrderController::class, 'declineOffer']);
        Route::get('/accept/report/{id}', [OrderController::class, 'acceptReport']);
        Route::get('/decline/report/{id}', [OrderController::class, 'declineReport']);
        Route::get('/delete/{id}', [OrderController::class, 'delete']);
        Route::get('/{id}', [OrderController::class, 'details'])->name('details');
    });
});
