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
Route::resource('admin/post', 'Admin\PostController');

// ----------------- STUDENT ---------------- //
Route::resource('student/post', 'Student\PostController')->only(['index','show']);
