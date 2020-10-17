<?php

namespace Modules\Training\Http\Controllers\Admin;

use App\Http\Resources\CourseResource as CourseResource;
use App\Trainer;
use Carbon\Carbon;
use DateTimeZone;
use Illuminate\Contracts\Support\Renderable;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller ;
use Modules\Store\Entities\Item;
use Modules\Training\Entities\Course;
use Validator;

class CourseController extends Controller
{

    public function __construct(Request $request)
    {
        parent::__construct($request);
        $this->middleware(['authorizor:admins'])->except(['index','show']);
    }

    public function index()
    {
        $courses = Course::all();
        return response()->json(CourseResource::collection($courses),200) ;
    }

    public function create()
    {
    }

    public function store(Request $request)
    {
        $rules = Course::$rules;
        $rules+=['trainer_id'=>'required'];
        $valditor = Validator::make($request->all(), $rules,Course::$messages);

        if($valditor->fails()){
            return response()->json($valditor->errors(),401);
        }
        $course = Course::create($valditor->validated());
        $trainer_id = $request->trainer_id;
        $trainer = Trainer::find($trainer_id);

        $trainer->courses()->save($course);

        $item = Item::create([
            'price' => $request->input('price'),
            'approved_at' => Carbon::now(new DateTimeZone('Asia/riyadh')),
        ]);

        $course->item()->save($item);

        return response()->json([
            'success' =>[
                'en' =>'add done',
                'ar' => 'تمت اضافة هذا الكورس بنجاح'
            ],
            'course' => new CourseResource($course)
        ],200);
    }

    public function show(Course $course)
    {
        return response()->json([CourseResource::collection($course)],200);
    }

    public function edit(Course $course)
    {
        return response()->json([CourseResource::collection($course)],200);
    }

    public function update(Request $request, Course $course)
    {
        $valditor = Validator::make($request->all(), Course::$rules,Course::$messages);
        if($valditor->fails()){
            return response()->json($valditor->errors(),401);
        }
        $course->update($valditor->validated());
            return response()->json([
                'success' =>[
                    'en' =>'add done',
                    'ar' => 'تمت اضافة هذا الكورس بنجاح'
                ],
                'course' => CourseResource::collection($course)
        ],200);
    }

    public function destroy(Course $course)
    {
        $course->sections()->delete();
        $course->lessons()->delete();
        $course->exam()->delete();
        $course->assignments()->delete();
        $course->certifications()->delete();
        $course->evaluations()->delete();
        $course->item()->delete();
        $course->delete();

        return response()->json([
            'success' =>[
                'en' =>'delete done',
                'ar' => 'تمت حذف هذا الكورس بنجاح'
            ],
            'course' => CourseResource::collection($course)
        ],200);

    }
}
