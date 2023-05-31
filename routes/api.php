<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\ListingController;
use App\Traits\Response;
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


Route::group(['middleware' => ['json', 'throttle:60,1']], function () {

    Route::get('/', function () {
        return Response::successResponse('Welcome to PHP Job Board');
    });

    Route::post('login', [AuthController::class, 'login'])->name('login');
    Route::get('listings', [ListingController::class, 'index']);
    Route::get('listing/{listing}', [ListingController::class, 'show'])->name('listing.show')->withTrashed();
    Route::post('listing', [ListingController::class, 'store'])->name('listing.create');

    Route::group(['middleware' => ['auth:sanctum']], function () {

        Route::group(['middleware' => ['super_admin']], function () {
            Route::prefix('user')->group(function () {
                Route::get('/{user}', [AuthController::class, 'show']);
                Route::delete('/{user}', [AuthController::class, 'delete']);
            });

            Route::get('users', [AuthController::class, 'index'])->name('users');
            Route::post('register', [AuthController::class, 'register'])->name('create.user');
        });

        Route::prefix('listings')->group(function () {
            Route::get('/{status}', [ListingController::class, 'getListings']);
            Route::post('/delete', [ListingController::class, 'bulkDelete'])->name('listings.bulkDelete');
            Route::post('/restore', [ListingController::class, 'bulkRestore'])->name('listings.bulkRestore');
            Route::post('/publish', [ListingController::class, 'bulkPublish'])->name('listings.bulkPublish');
            Route::post('/draft', [ListingController::class, 'bulkDraft'])->name('listings.bulkDraft');
        });

        Route::prefix('listing')->group(function () {
            Route::post('/{listing}', [ListingController::class, 'update'])->name('listing.update');
            Route::post('/{listing}/restore', [ListingController::class, 'restore'])->name('listing.restore')->withTrashed();
            Route::delete('/{listing}', [ListingController::class, 'destroy'])->name('listing.delete');
        });

        Route::get('logout', [AuthController::class, 'logout']);
    });
});
