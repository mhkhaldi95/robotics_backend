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

// Route::middleware('auth:api')->get('/accounts', function (Request $request) {
//     return $request->user();
// });

Route::post('/account/update-profile/{student}','Student\UpdateStudentProfileController@update');
Route::post('/account/update-password/{student}','Student\UpdateStudentPasswordController@update');
