<?php

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

Route::middleware('auth:api')->get('/competition', function (Request $request) {
    return $request->user();
});

//Route::prefix('competition')->group(function() {
//
//    Route::get('/index', 'CompetitionController@index');
//    Route::post('/store', 'CompetitionController@store');
//    Route::get('/show/{competition}', 'CompetitionController@show');
//    Route::get('/edit/{competition}', 'CompetitionController@edit');
//    Route::post('/update/{competition}', 'CompetitionController@update');
//    Route::delete('/delete/{competition}', 'CompetitionController@destroy');
//
//});
