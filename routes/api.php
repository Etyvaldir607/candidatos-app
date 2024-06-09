<?php

use App\Http\Controllers\ApplicantsController;
use App\Http\Controllers\Auth\AuthController;
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


Route::controller(AuthController::class)
    ->group(function () {
        Route::post('login', 'login')->name('login');

        Route::middleware('auth:api')
            ->group(function () {

                Route::post('logout', 'logout')->name('logout');
                Route::post('refresh', 'refresh')->name('refresh');

                Route::prefix('/lead')
                    ->controller(ApplicantsController::class)
                    ->group(function () {
                        Route::get('/', 'index')->name('manager.applicants.index');
                        Route::post('/', 'store')->name('manager.applicants.store');
                        Route::get('/{id}', 'show')->name('manager.applicants.show');
                    });
            });

    });





//Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
//    return $request->user();
//});
