<?php

namespace Modules\Training\Http\Controllers;

use Illuminate\Contracts\Support\Renderable;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Modules\Training\Entities\Question;

class QuestionController extends Controller
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
        $valditor = Validator::make($request->all(), Question::$rules,Question::$messages);

        if($valditor->fails()){
            return response()->json($valditor->errors(),404);
        }

        $question = Question::create($valditor->validated());
        $exam =$question->exam;
        $exam->questions()->save($question);
        return response()->json($question);
    }

    /**
     * Show the specified resource.
     * @param int $id
     * @return Renderable
     */
    public function show(Question $question)
    {
        return response()->json($question,200);
    }

    /**
     * Show the form for editing the specified resource.
     * @param int $id
     * @return Renderable
     */
    public function edit(Question $question)
    {
        return response()->json($question,200);
    }

    /**
     * Update the specified resource in storage.
     * @param Request $request
     * @param int $id
     * @return Renderable
     */
    public function update(Request $request, Question $question)
    {
        $valditor = Validator::make($request->all(), Question::$rules,Question::$messages);

        if($valditor->fails()){
            return response()->json($valditor->errors(),404);
        }

        $question->update($valditor->validated());
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
    public function destroy(Question $question)
    {
        $question->answers()->delete();
        $question->delete();
        return response()->json($question,200);
    }
}
