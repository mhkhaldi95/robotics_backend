<?php

namespace Modules\Training\Http\Controllers\Admin;

use App\Student;
use Carbon\Carbon;
use DateTimeZone;
use Illuminate\Contracts\Support\Renderable;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller ;
use Modules\Training\Entities\Course;
use Validator;

class CourseStudentController extends Controller
{
    public function __construct(Request $request)
    {
        parent::__construct($request);
        $this->middleware(['authorizor:admins']);
    }
    public function index()
    {
        return view('training::index');
    }

    /**
     * Show the form for creating a new resource.
     * @return Renderable
     */
    public function create()
    {
        return view('training::create');
    }

    /**
     * Store a newly created resource in storage.
     * @param Request $request
     * @return Renderable
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Show the specified resource.
     * @param int $id
     * @return Renderable
     */
    public function show($id)
    {
        return view('training::show');
    }

    /**
     * Show the form for editing the specified resource.
     * @param int $id
     * @return Renderable
     */
    public function edit($id)
    {
        return view('training::edit');
    }

    /**
     * Update the specified resource in storage.
     * @param Request $request
     * @param int $id
     * @return Renderable
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     * @param int $id
     * @return Renderable
     */
    public function destroy(Course $course , Student $student)
    {
        $studentCourse = $student->courses->find($course);
        if($studentCourse == null){
            return response()->json([
                'success' =>[
                    'en' =>'The student is not registered in this course',
                    'ar' => ' الطالب غير مسجل في هذا الكورس'
                ],
            ],200);
        }

        if($studentCourse->pivot['withdraw_at'] != null){
            return response()->json([
                'success' =>[
                    'en' =>'The course has already been deleted',
                    'ar' => ' الكورس  محذوف مسبقا'
                ],
            ],200);
        }

        $studentCourse->pivot['withdraw_at'] = Carbon::now(new DateTimeZone('Asia/riyadh'));
        $studentCourse->pivot->save();

        return response()->json([
            'success' =>[
                'en' =>'delete done',
                'ar' => 'تم حذف هذا الكورس بنجاح'
            ],
            'course' => $studentCourse
        ],200);
    }
}
