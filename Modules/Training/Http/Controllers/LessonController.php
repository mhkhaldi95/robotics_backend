<?php

namespace Modules\Training\Http\Controllers;

use Illuminate\Contracts\Support\Renderable;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Modules\Training\Entities\Lesson;
use Validator;

class LessonController extends Controller
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
        $valditor = Validator::make($request->all(), Lesson::$rules,Lesson::$messages);

        if($valditor->fails()){
            return response()->json($valditor->errors(),404);
        }

        $lesson = Lesson::create($valditor->validated());
        $section =$lesson->section;
        $section->lessons()->save($lesson);
        return response()->json($lesson);

    }

    /**
     * Show the specified resource.
     * @param int $id
     * @return Renderable
     */
    public function show(Lesson $lesson)
    {
        return response()->json($lesson,200);
    }

    /**
     * Show the form for editing the specified resource.
     * @param int $id
     * @return Renderable
     */
    public function edit(Lesson $lesson)
    {
        return response()->json($lesson,200);
    }

    /**
     * Update the specified resource in storage.
     * @param Request $request
     * @param int $id
     * @return Renderable
     */
    public function update(Request $request, Lesson $lesson)
    {
        $valditor = Validator::make($request->all(), Lesson::$rules,Lesson::$messages);

        if($valditor->fails()){
            return response()->json($valditor->errors(),404);
        }

        $lesson->update($valditor->validated());
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
    public function destroy(Lesson $lesson)
    {
        $lesson->attendances->delete();
        $lesson->delete();
        return response()->json($lesson,200);
    }
}
