<?php

use App\Http\Controllers\Api\v1\AuthController;
use App\Http\Controllers\Api\v1\CityController;
use App\Http\Controllers\Api\v1\DictionaryController;
use App\Http\Controllers\Api\v1\ExecutorController;
use App\Http\Controllers\Api\v1\OfferControler;
use App\Http\Controllers\Api\v1\OrderController;
use App\Http\Controllers\Api\v1\ReviewController;
use App\Http\Controllers\Api\v1\SupportController;
use App\Http\Controllers\Api\v1\ReportController;
use App\Http\Controllers\Api\v1\UserController;
use App\Http\Controllers\Api\v1\VerificationController;
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

Route::group(['prefix' => 'v1'], function () {
    Route::get('cities', [CityController::class, 'index']);
    Route::get('urgency_types', [DictionaryController::class, 'urgency']);
    Route::get('business_types', [DictionaryController::class, 'businessTypes']);
    Route::post('support', [SupportController::class, 'send']);

    Route::post('/register', [AuthController::class, 'register']);
    Route::post('/login', [AuthController::class, 'login']);
    Route::post('/logout', [AuthController::class, 'logout'])->middleware('auth:sanctum');

    Route::post('/verification/sendverify', [UserController::class, 'sendTwoVerify']);
    Route::post('/verification/verify', [UserController::class, 'verifyTwo']);

    // Route::post('/email/sendverify', [UserController::class, 'sendVerify']);
    // Route::post('/email/verify', [UserController::class, 'verifyEmail']);
    // Route::post('/phone/sendverify', [UserController::class, 'sendOtp']);
    // Route::post('/phone/verify', [UserController::class, 'verifyOtp']);

    Route::post('/forgot-password', [AuthController::class, 'sendForgot']);
    Route::post('/reset-password', [AuthController::class, 'reset']);

    Route::group(['prefix' => 'order'], function () {
        Route::get('', [OrderController::class, 'index']);

        Route::post('/{id}/user', [OrderController::class, 'ordersIndexByUserId']);

        Route::group(['middleware' => 'auth:api-user'], function () {
            Route::get('/history', [OrderController::class, 'userOrders']);
            Route::post('', [OrderController::class, 'create'])->middleware('verified');

            Route::group(['prefix' => '/{id}'], function () {
                Route::get('', [OrderController::class, 'info']);
                Route::post('/update', [OrderController::class, 'update']);

                Route::post('/wait_report', [OrderController::class, 'waitReport']); // TODO Timer
                Route::post('/approve', [OrderController::class, 'approve']);
                Route::post('/not_approve', [OrderController::class, 'notApprove']);

                Route::get('/offers', [OrderController::class, 'offers']);
                Route::delete('/delete', [OrderController::class, 'delete']);
            });
        });
        Route::get('/{id}', [OrderController::class, 'info']);
    });

    Route::group(['prefix' => 'user', 'middleware' => 'verified'], function () {
        Route::post('/update', [UserController::class, 'update'])->middleware('auth:api-user');
        Route::post('/update-token', [UserController::class, 'updateToken'])->middleware('auth:api-user');
        Route::get('/{id}', [UserController::class, 'info']);
    });

    Route::group(['prefix' => 'executor'], function () {
        Route::get('/offers', [ExecutorController::class, 'offers'])->middleware(['auth:api-executor']);
        Route::get('/{id}', [ExecutorController::class, 'info']);
        Route::post('create', [ExecutorController::class, 'create']);
        Route::post('update', [ExecutorController::class, 'update'])->middleware(['auth:api-executor']);
        Route::post('/update-token', [ExecutorController::class, 'updateToken'])->middleware(['auth:api-executor']);
    });

    Route::group(['prefix' => 'review', 'middleware' => 'auth:api-user'], function () {
        Route::post('', [ReviewController::class, 'create']);
    });

    Route::group(['prefix' => 'offer'], function () {
        Route::post('', [OfferControler::class, 'create'])->middleware('auth:api-executor');

        Route::group(['middleware' => 'auth:api-user', 'middleware' => 'verified'], function () {
            Route::post('/{id}/accept', [OfferControler::class, 'accept']);
            Route::post('/{id}/decline', [OfferControler::class, 'decline']);
        });
    });

    Route::group(['prefix' => 'report'], function () {
        Route::post('', [ReportController::class, 'index']);

        Route::group(['middleware' => 'auth:api-executor'], function () {
            Route::post('/{id}/before', [ReportController::class, 'storeReportBefore']);
            Route::post('/{id}/after', [ReportController::class, 'storeReportAfter']);
        });
    });
});
