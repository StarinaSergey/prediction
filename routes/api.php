<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\StudyController;
use App\Http\Controllers\LanguageController;

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

Route::group(['prefix' => 'study', 'namespace' => 'Study'], function () {
    Route::get('/get-list', [StudyController::class, 'GetList']);
});

Route::group(['prefix' => 'language', 'namespace' => 'Language'], function () {
    Route::get('/get-list', [LanguageController::class, 'GetList']);
});
