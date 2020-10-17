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

Route::middleware('auth:api')->get('/team', function (Request $request) {
    return $request->user();
});
//عرض كل الفرق
Route::resource('teams', 'Student\TeamController')->only(['index','show']);
//انشاء فريق من قبل الطالب
Route::resource('student.team', 'Student\TeamStudentController')->only(['index','store']);

//دعوة للانضمام للفريق من قبل عضو داخل الفريق
Route::post('/invite/team/{team}/student/{student}','Student\InvitationStudentController@store')->name('memberTeamInvitation');
//قبول ورفض الدعوة من قبل الطالب
Route::resource('invitation.student', 'Student\AcceptInvitationStudentController')->only(['destroy','store']);
//طلب للانضمام للفريق بدون دعوة من الداخل

Route::resource('team.student', 'Student\JoinRequestStudentController')->only(['store']);
//قبول ورفض طلب الانضمام
Route::resource('joinRequest.student', 'Student\AcceptJoinRequestStudentController')->only(['destroy','store']);

//admin
Route::resource('admin/team', 'Admin\TeamController');
// اضافة طالب للفريق
Route::post('admin/team/{team}/student/{student}', 'Admin\TeamStudentController@store');
Route::delete('admin/team/{team}/student/{student}', 'Admin\TeamStudentController@destroy');
Route::delete('admin/team/{team}/student/{student}/newLeader/{newLeader}', 'Admin\TeamStudentController@destroy');

