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



Route::resource('admin/event', 'Admin\EventController');
Route::resource('admin/event.schedule', 'Admin\ScheduleController');
Route::resource('admin/schedule.context', 'Admin\ContextController');

Route::resource('student/event', 'Student\EventController')->only(['index','show']);
Route::resource('student/event.schedule', 'Student\ScheduleController')->only(['index','show']);
Route::resource('student/schedule.context', 'Student\ContextController')->only(['index','show']);

