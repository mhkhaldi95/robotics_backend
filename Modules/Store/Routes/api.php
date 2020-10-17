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

Route::middleware('auth:api')->get('/store', function (Request $request) {
    return $request->user();
});

//student
// Route::resource('packageItem.student', 'Student\PackagePurchaseStudentController');
Route::resource('packageItem.purchase', 'Student\PackagePurchaseController', ['only' => ['store']]);

// admin
Route::resource('package/purchase.student', 'Admin\AcceptPurchasePackageController', ['only' => ['store']]);

Route::post('/admin/student/{student}/packageItem/{packageItem}', 'Admin\PackagePurchaseStudentController@store');

