<?php

namespace Modules\Training\Http\Controllers;

use Illuminate\Contracts\Support\Renderable;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Modules\Training\Entities\Exam;
use Validator;

class ExamController extends Controller
{
    /**
     * Display a listing of the resource.
     * @return Renderable
     */
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
        $valditor = Validator::make($request->all(), Exam::$rules,Exam::$messages);

        if($valditor->fails()){
            return response()->json($valditor->errors(),404);
        }

        $exam = Exam::create($valditor->validated());
        $course =$exam->course;
        $course->exam()->save($exam);
        return response()->json($exam);
    }

    /**
     * Show the specified resource.
     * @param int $id
     * @return Renderable
     */
    public function show(Exam $exam)
    {
        return response()->json($exam,200);
    }

    /**
     * Show the form for editing the specified resource.
     * @param int $id
     * @return Renderable
     */
    public function edit(Exam $exam)
    {
        return response()->json($exam,200);
    }

    /**
     * Update the specified resource in storage.
     * @param Request $request
     * @param int $id
     * @return Renderable
     */
    public function update(Request $request, Exam $exam)
    {
        $valditor = Validator::make($request->all(), Exam::$rules,Exam::$messages);

        if($valditor->fails()){
            return response()->json($valditor->errors(),404);
        }

        $exam->update($valditor->validated());
        return response()->json([
            'success' => true,
            'message' => 'sucess'
        ]);
    }

    /**
     * Remove the specified resource from storage.
     * @param int $id
     * @return Renderable
     */
    public function destroy(Exam $exam)
    {
        $exam->questions()->delete();
        $exam->delete();
        return response()->json($exam,200);
    }
}
