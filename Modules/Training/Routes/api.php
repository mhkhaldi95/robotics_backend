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

Route::middleware('auth:api')->get('/training', function (Request $request) {
    return $request->user();
});

Route::prefix('training')->group(function() {
    Route::prefix('admin')->group(function(){

        Route::resource('course', 'Admin\CourseController');
        Route::resource('course/purchase.student', 'Admin\AcceptPurchaseCourseController', ['only' => ['store']]);
        Route::resource('course.student', 'Admin\CourseStudentController', ['only' => ['destroy']]);
        Route::resource('course.section', 'Admin\CourseSectionController', ['only' => ['index','store','destroy']]);
        Route::resource('section.lesson', 'Admin\SectionLessonController', ['only' => ['index','store','destroy']]);
        Route::resource('course.question', 'Admin\QuestionController', ['only' => ['index','store','destroy']]);

    });

    Route::prefix('student')->group(function(){
        Route::resource('courseItem.purchase', 'Student\CoursePurchaseController', ['only' => ['store']]);
        Route::resource('course', 'Student\CourseStudentController', ['only' => ['index','store','destroy']]);
        Route::resource('course.evaluation', 'Student\CourseEvaluationController', ['only' => ['index','store','destroy']]);
        Route::post('course/{course}/evaluation/{evaluation}', 'Student\CourseEvaluationController@store');
        Route::resource('course.exam', 'Student\ExamStudentController', ['only' => ['index','store','destroy']]);
        Route::post('/finish-exam/{exam}/{score}', 'Student\FinishExamStudentController', ['only' => ['update']]);
    });
});


