<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\Authentication\AuthController;
use App\Http\Controllers\Api\User\ProfileController;
use App\Http\Controllers\Api\User\AlertController;
use App\Http\Controllers\Api\Analytics\SubscribersController;

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

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});

/*
|--------------------------------------------------------------------------
| Authentication API Routes
|--------------------------------------------------------------------------
|
|
*/

Route::prefix('v1')->group(function () {

    Route::prefix('auth')->group(function () {

        Route::post('login', [AuthController::class, 'login'])->name('login');

        Route::post('register', [AuthController::class, 'register'])->name('register');

        Route::get('email/verify/{id}', [AuthController::class, 'verify'])->name('verification.verify'); // Make sure to keep this as your route name

        Route::get('email/resend', [AuthController::class, 'resend'])->name('verification.resend');

    });

    Route::prefix('profile')->group(function () {

        Route::prefix('basic_info')->group(function () {

            Route::post('create', [ProfileController::class, 'create'])->name('create');

            Route::post('update', [ProfileController::class, 'update'])->name('update');

            Route::post('revert', [ProfileController::class, 'revert'])->name('revert');

        });

    });

    Route::prefix('alerts')->group(function () {

        Route::post('create', [AlertController::class, 'create'])->name('create');

        Route::get('delete', [AlertController::class, 'delete'])->name('delete');

    });

    Route::prefix('subscription')->group(function () {

        Route::post('subscribe', [SubscribersController::class, 'subscribe']);

        Route::post('unsubscribe', [SubscribersController::class, 'unsubscribe']);

        Route::get('subscribers', [SubscribersController::class, 'getSubscribers']);

    });

});
