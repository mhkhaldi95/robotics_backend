<?php

namespace Modules\Training\Http\Controllers;

use Illuminate\Contracts\Support\Renderable;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Modules\Training\Entities\Assignment;
use Validator;

class AssignmentController extends Controller
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
        $valditor = Validator::make($request->all(), Assignment::$rules,Assignment::$messages);

        if($valditor->fails()){
            return response()->json($valditor->errors(),404);
        }

        $assignment = Assignment::create($valditor->validated());
        $course = $assignment->course;
        $course->assignments()->save($assignment);
    }

    /**
     * Show the specified resource.
     * @param int $id
     * @return Renderable
     */
    public function show(Assignment $assignment)
    {
        return response()->json($assignment,200);
    }

    /**
     * Show the form for editing the specified resource.
     * @param int $id
     * @return Renderable
     */
    public function edit(Assignment $assignment)
    {
        return response()->json($assignment,200);
    }

    /**
     * Update the specified resource in storage.
     * @param Request $request
     * @param int $id
     * @return Renderable
     */
    public function update(Request $request, Assignment $assignment)
    {
        $valditor = Validator::make($request->all(), Assignment::$rules,Assignment::$messages);

        if($valditor->fails()){
            return response()->json($valditor->errors(),404);
        }

        $assignment->update($valditor->validated());
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
    public function destroy(Assignment $assignment)
    {
        $assignment->submission()->delete();
        $assignment->delete();
        return response()->json($assignment,200);
    }
}
