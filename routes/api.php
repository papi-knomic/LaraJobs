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
        return Response::successResponse('Welcome');
    });

    //login
    Route::post('login', [AuthController::class, 'login'])->name('login');

    //get listing
    Route::get('listing/{listing}', [ListingController::class, 'show'])->name('listing.show');

    //protected routes
    Route::group(['middleware' => ['auth:sanctum']], function () {
        //super admin routes
        Route::group(['middleware' => ['super_admin']], function () {
            // user route group
            Route::prefix('user')->group(function () {
                //get single user
               Route::get('/{user}', [AuthController::class, 'show']);
               //delete user
                Route::delete('/{user}', [AuthController::class, 'delete']);
            });
            //get users
            Route::get('users', [AuthController::class, 'index'])->name('users');
            //create user
            Route::post('register', [AuthController::class, 'register'])->name('create.user');
        });

        Route::prefix('listing')->group(function (){
            //Create Listing
            Route::post('/', [ListingController::class, 'store'])->name('listing.create');
            //update listing
            Route::put('/{listing}', [ListingController::class, 'update'])->name('listing.update');
            //Change Listing Status
            Route::post('/{listing}/status', [ListingController::class, 'updateStatus'])->name('listing.update.status');
            //delete listing
            Route::delete('/{listing}', [ListingController::class, 'destroy'])->name('listing.delete');
        });

        //logout
        Route::get('logout', [AuthController::class, 'logout']);
    });
});
