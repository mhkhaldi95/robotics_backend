<?php

namespace Modules\Training\Http\Controllers\Student;

use Illuminate\Contracts\Support\Renderable;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller ;
use Modules\Training\Entities\Course;
use Modules\Training\Entities\Evaluation;

class CourseEvaluationController extends Controller
{
    public function __construct(Request $request)
    {
        parent::__construct($request);
        $this->middleware(['authorizor:students']);
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
    public function store(Request $request,Course $course,$evaluation)
    {
        if(!$this->user->courses->find($course)){
            return response()->json([
                'success' => false,
                'message' => 'انت لا تنتمي لهذا الكورس',
            ]);
        }
        $eval = Evaluation::where('course_id',$course->id)->where('student_id',$this->user->id)->first();
        if($eval==null){
            $Evaluation = Evaluation::create([
                'course_id'=>$course->id,
                'student_id'=>$this->user->id,
                'value'=>$evaluation,
            ]);
                   return response()->json([
                       'success' =>[
                           'en' =>'evaluation done',
                           'ar' => 'تم التقييم بنجاح'
                       ],
                       'Evaluation' => $Evaluation,
                   ],200);

        }
        $this->update($request,$eval,$evaluation);
        return response()->json([
            'success' =>[
                'en' =>'evaluation done',
                'ar' => 'تم التقييم بنجاح'
            ],
            'Evaluation' => $evaluation,
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
    public function update(Request $request,$eval,$evaluation)
    {
        $eval->update([
            'value'=>$evaluation
        ],200);
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
