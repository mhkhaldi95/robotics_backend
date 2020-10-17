<?php

namespace Modules\Training\Http\Controllers;

use Illuminate\Contracts\Support\Renderable;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Modules\Training\Entities\Answer;
use Validator;

class AnswerController extends Controller
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
        $valditor = Validator::make($request->all(), Answer::$rules,Answer::$messages);

        if($valditor->fails()){
            return response()->json($valditor->errors(),404);
        }

        $answer = Answer::create($valditor->validated());
        $question =$answer->question;
        $question->answers()->save($answer);
        return response()->json($answer);
    }

    /**
     * Show the specified resource.
     * @param int $id
     * @return Renderable
     */
    public function show(Answer $answer)
    {
        return response()->json($answer,200);
    }

    /**
     * Show the form for editing the specified resource.
     * @param int $id
     * @return Renderable
     */
    public function edit(Answer $answer)
    {
        return response()->json($answer,200);
    }

    /**
     * Update the specified resource in storage.
     * @param Request $request
     * @param int $id
     * @return Renderable
     */
    public function update(Request $request, Answer $answer)
    {
        $valditor = Validator::make($request->all(), Answer::$rules,Answer::$messages);

        if($valditor->fails()){
            return response()->json($valditor->errors(),404);
        }

        $answer->update($valditor->validated());
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
    public function destroy(Answer $answer)
    {
        $answer->delete();
        return response()->json($answer,200);
    }
}
