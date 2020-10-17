<?php

namespace Modules\Training\Http\Controllers\Admin;

use Illuminate\Contracts\Support\Renderable;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller ;
use Modules\Training\Entities\Answer;
use Modules\Training\Entities\Choice;
use Modules\Training\Entities\Course;
use Modules\Training\Entities\Question;

class QuestionController extends Controller
{
    public function __construct(Request $request)
    {
        parent::__construct($request);
        $this->middleware(['authorizor:admins'])->except(['index','show']);
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
    public function store(Request $request ,Course $course)
    {
        foreach ($request->all() as $index=>$question){

            $newQuestion = Question::create([
                'content' => $question['question'.($index+1)]
                ]);
                for ($i=1;$i<=5;$i++){
                    $newChoice = Choice::create([
                        'content' =>  $question['answer'.$i]
                    ]);
                    if($i == 1){
                        $answer = Answer::create([
                           'content'=>$newChoice->content
                        ]);
                        $newQuestion->answer()->save($answer);

                    }
                        $newQuestion->choices()->save($newChoice);
                }

             $course->questions()->save($newQuestion);
        }
        return response()->json([
            'success' =>[
                'en' =>'add done',
                'ar' => 'تمت الاضافة بنجاح'
            ]],200);

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
