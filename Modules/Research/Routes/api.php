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

// ----------------- ADMIN ---------------- //
Route::resource('admin/research', 'Admin\ResearchController');

// accept user Researches
Route::prefix('admin/research')->group(function() {
    Route::get('/userResearches','Admin\AcceptResearchController@index');
    Route::post('/userResearches/accept/{research}','Admin\AcceptResearchController@store');
    Route::get('/userResearches/show/{research}','Admin\AcceptResearchController@show');
    Route::get('/userResearches/edit/{research}','Admin\AcceptResearchController@edit');

    // Route::resource('admin/research.userResearches', 'Admin\AcceptResearchController');
});

// ----------------- STUDENT ---------------- //
Route::resource('student/research', 'Student\ResearchController')->only(['index','store','show']);
