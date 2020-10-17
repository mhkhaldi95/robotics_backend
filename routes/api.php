<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
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

Route::post('/register','AuthController@register');
Route::post('/login','AuthController@login')->name('login');
Route::get('/me','AuthController@me');
Route::resource('admin', 'Admin\AdminController');
Route::post('/admin/update/{admin}',  'Admin\AdminController@update');

Route::prefix('admin')->group(function() {



    Route::prefix('student')->group(function() {
        Route::post('/register', 'Admin\StudentController@register');
        Route::post('/update/{student}', 'Admin\StudentController@update');
        Route::get('/show/{student}', 'Admin\StudentController@show');
        Route::delete('/delete/{student}', 'Admin\StudentController@destroy');
    });

     Route::prefix('father')->group(function() {
        Route::post('/register', 'Admin\FatherController@register');
        Route::post('/update/{father}', 'Admin\FatherController@update');
        Route::get('/show/{father}', 'Admin\FatherController@show');
    });

    Route::prefix('trainer')->group(function() {
        Route::post('/register', 'Admin\TrainerController@register');
        Route::post('/update/{trainer}', 'Admin\TrainerController@update');
        Route::get('/show/{trainer}', 'Admin\TrainerController@show');
    });

});

route::get('/notifications','StudentNotificationController@index');
route::get('/notification/{id}','StudentNotificationController@read');



