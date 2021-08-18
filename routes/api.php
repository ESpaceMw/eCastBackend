<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\Authentication\AuthController;
use App\Http\Controllers\Api\User\ProfileController;
use App\Http\Controllers\Api\User\AlertController;
use App\Http\Controllers\Api\Analytics\SubscribersController;
use App\Http\Controllers\Api\User\CategoryController;
use App\Http\Controllers\Api\Podcast\PodcastsController;

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

    Route::prefix('category')->group(function () {

        Route::post('user-create', [CategoryController::class, 'createUserCategory']);

        Route::get('categories', [CategoryController::class, 'getInterestCategories']);

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

    Route::prefix('podcasts')->group(function () {

        Route::prefix('series')->group(function () {

            Route::post('create', [PodcastsController::class, 'createSeries']);

            Route::post('delete', [PodcastsController::class, 'deleteSeries']);

        });

        Route::prefix('episodes')->group(function () {

            Route::post('create', [PodcastsController::class, 'createEpisode']);

            Route::post('delete', [PodcastsController::class, 'deleteSeries']);

        });

    });

});
