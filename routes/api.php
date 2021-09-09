<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\Authentication\AuthController;
use App\Http\Controllers\Api\User\ProfileController;
use App\Http\Controllers\Api\User\AlertController;
use App\Http\Controllers\Api\User\SearchController;
use App\Http\Controllers\Api\Analytics\SubscribersController;
use App\Http\Controllers\Api\Analytics\ChannelsController;
use App\Http\Controllers\Api\User\CategoryController;
use App\Http\Controllers\Api\User\SubscriptionController;
use App\Http\Controllers\Api\Podcast\PodcastsController;
use App\Http\Controllers\Api\Podcast\EventsController;
use App\Http\Controllers\Api\Podcast\MediaController;
use App\Http\Controllers\Api\Analytics\StatisticsController;
use App\Http\Controllers\Api\Overview\InboxController;


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

        Route::post('logout', [AuthController::class, 'logout'])->name('logout');

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

        Route::post('get-alerts', [AlertController::class, 'getAlerts'])->name('get-alerts');

        Route::post('delete', [AlertController::class, 'delete'])->name('delete');

    });

    Route::prefix('subscription')->group(function () {

        Route::post('subscribe', [SubscribersController::class, 'subscribe']);

        Route::post('unsubscribe', [SubscribersController::class, 'unsubscribe']);

        Route::post('subscribers', [SubscribersController::class, 'getSubscribers']);

        Route::post('new-subscribers', [SubscribersController::class, 'getNewSubscribers']);

    });

    Route::prefix('subscription')->group(function () {

        Route::get('hosting-plans', [SubscriptionController::class, 'hostingPlans']);

        Route::post('pay-hosting-plan', [SubscriptionController::class, 'store']);

    });

    Route::prefix('podcasts')->group(function () {

        Route::prefix('series')->group(function () {

            Route::post('create', [PodcastsController::class, 'createSeries']);

            Route::post('get', [PodcastsController::class, 'getChannelSeries']);

            Route::post('delete', [PodcastsController::class, 'deleteSeries']);

        });

        Route::prefix('episodes')->group(function () {

            Route::post('create', [PodcastsController::class, 'createEpisode']);

            Route::post('listen-create', [PodcastsController::class, 'addListen']);

            Route::get('popular-podcasts', [PodcastsController::class, 'getPopularPodcasts']);

            Route::post('delete', [PodcastsController::class, 'deleteSeries']);

            Route::get('all', [PodcastsController::class, 'getEpisodes']);

        });

        Route::prefix('media')->group(function () {

            Route::post('photos', [MediaController::class, 'getPhotos']);

            Route::post('audios', [MediaController::class, 'getAudios']);
        });

    });

    Route::prefix('channels')->group(function () {

        Route::get('get', [ChannelsController::class, 'getChannels']);

        Route::post('update-channel', [ChannelsController::class, 'updateChannel']);

        Route::post('listener-review-create', [ChannelsController::class, 'createReview']);

        Route::post('listener-review-get', [ChannelsController::class, 'getReviews']);

    });

    Route::prefix('statistics')->group(function () {

        Route::get('countries', [StatisticsController::class, 'countriesListening']);

        Route::get('listens-by-gender', [StatisticsController::class, 'getListensByGender']);

        Route::get('annual-listens', [StatisticsController::class, 'getAnnualListens']);
    });

    Route::prefix('events')->group(function () {

        Route::post('create', [EventsController::class, 'create']);

        Route::post('edit', [EventsController::class, 'edit']);

        Route::post('promote', [EventsController::class, 'promote']);

        Route::post('get', [EventsController::class, 'getEvents']);

    });

    Route::prefix('search')->group(function () {

        Route::post('recent-create', [SearchController::class, 'create']);

        Route::post('recent-get', [SearchController::class, 'get']);

    });

    Route::prefix('inbox')->group(function () {


        Route::get('messages/fetch', [InboxController::class, 'fetchMessages']);
        Route::post('messages/send', [InboxController::class, 'sendMessage']);

    });

});
