<?php

namespace Modules\Training\Http\Controllers\Student;

use Illuminate\Contracts\Support\Renderable;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller ;
use Modules\Training\Entities\Course;
use Modules\Training\Entities\Exam;
use Modules\Training\Entities\Question;
use Modules\Training\Transformers\QuestionResource as QuestionResource;

class ExamStudentController extends Controller
{
    public function __construct(Request $request)
    {
        parent::__construct($request);
        $this->middleware(['authorizor:students'])->except(['index','show']);
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
    public function store(Request $request,Course $course)
    {
//        return response()->json($course->questions[0]->answer);
        if($this->user->courses->find($course)){
            $exam = Exam::where('course_id',$course->id)->where('student_id',$this->user->id)->first();
            if($exam != null){
                //افحص انو الطالب قدم امتحان لهذا الكورس
                return response()->json([
                    'success' =>[
                        'en' =>'You have taken the test before',
                        'ar' => 'لقد تقدمت للاختبار من قبل'
                    ],
                ],200);
            }
            $exam = Exam::create([
               'student_id'=>$this->user->id

            ]);
            $course->exam()->save($exam);
            $questions = $course->questions->random(2);
            $exam->questions()->saveMany ($questions);
            return response()->json([
                'success' => true,
                'message' => ' تمت اضافة الامتحان بنجاح',
                'exam' =>  QuestionResource::collection($questions),
            ]);
        }
        return response()->json([
            'success' =>[
                'en' =>'You do not belong to this course',
                'ar' => 'أنت لا تنتمي لهذا الكورس'
            ],
        ],200);


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
    public function destroy($id)
    {
        //
    }
}
