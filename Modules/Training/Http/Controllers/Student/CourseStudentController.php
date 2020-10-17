<?php

namespace Modules\Training\Http\Controllers\Student;

use DateTimeZone;
use Illuminate\Contracts\Support\Renderable;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller ;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;
use Modules\Store\Entities\Order;
use Modules\Store\Entities\Purchase;
use Modules\Training\Entities\Course;

class CourseStudentController extends Controller
{
    public function __construct(Request $request)
    {
        parent::__construct($request);
        $this->middleware(['authorizor:students']);
    }

    public function index()
    {
        $courses = $this->user->courses->where('pivot.withdraw_at',null);
        return response()->json($courses);
    }

    public function create()
    {
    }

    public static function store(Request $request ,Course $courseItem ,$student = null)
    {
        if($student == null){
            $user = Auth::guard($request->attributes->get("guard"))->user();
        }else{
            $user = $student;
        }

        $user->courses()->attach($courseItem);
        return response()->json([
            'success' =>[
                'en' =>'This course has been subscribed',
                'ar' => 'تم الاشتراك بهذا الكورس'
            ],
        ]);
    }

    public function show(Course $course)
    {

    }

    public function destroy(Course $course)
    {
        $myCourse = $this->user->courses->find($course);
        if($myCourse == null){
            return response()->json([
                'error' =>[
                    'en' =>'You are not registered in this course',
                    'ar' => 'أنت غير مسجل في هذا الكورس'
                ],
            ]);
        }

        if($myCourse->pivot['withdraw_at'] != null){
            return response()->json([
                'error' =>[
                    'en' =>'You have already deleted the course',
                    'ar' => 'لقد قمت بحذف الكورس مسبقا '
                ],
            ]);
        }

        if($this->user->age < 15){
            return response()->json([

                'course' => $course,
                'error' =>[
                'en' =>'Your parent must agree',
                'ar' => 'يجب أن يوافق والدك'
            ],
            ]);
        }

        $myCourse->pivot['withdraw_at'] = Carbon::now(new DateTimeZone('Asia/riyadh'));
        $myCourse->pivot->save();

        return response()->json([
            'course' => $myCourse,
            'error' =>[
                'en' =>'delete done',
                'ar' => 'تم حذف هذا الكورس بنجاح'
            ],
        ]);
    }
}
