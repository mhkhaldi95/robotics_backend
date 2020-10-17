<?php

namespace Modules\Training\Http\Controllers\Student;

use Illuminate\Contracts\Support\Renderable;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller ;
use Modules\Training\Entities\Exam;

class FinishExamStudentController extends Controller
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
    public function store(Request $request)
    {


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
    public function update(Request $request,Exam $exam,$score)
    {
        $exam->update([
            'score'=>$score
        ]);
        return response()->json([
            'success' =>[
                'en' =>'exam done',
                'ar' => 'انتهى الاختبار'
            ],
            'score' => $score,
        ]);
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
