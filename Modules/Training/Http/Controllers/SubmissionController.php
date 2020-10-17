<?php

namespace Modules\Training\Http\Controllers;

use Illuminate\Contracts\Support\Renderable;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Modules\Training\Entities\Submission;
use Validator;

class SubmissionController extends Controller
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
        $valditor = Validator::make($request->all(), Submission::$rules,Submission::$messages);

        if($valditor->fails()){
            return response()->json($valditor->errors(),404);
        }

        $submission = Submission::create($valditor->validated());
        $assignment = $submission->course;
        $assignment->submission()->save($submission);
        return response()->json($submission);
    }

    /**
     * Show the specified resource.
     * @param int $id
     * @return Renderable
     */
    public function show(Submission $submission)
    {
        return response()->json($submission,200);
    }

    /**
     * Show the form for editing the specified resource.
     * @param int $id
     * @return Renderable
     */
    public function edit(Submission $submission)
    {
        return response()->json($submission,200);
    }

    /**
     * Update the specified resource in storage.
     * @param Request $request
     * @param int $id
     * @return Renderable
     */
    public function update(Request $request, Submission $submission)
    {
        $valditor = Validator::make($request->all(), Submission::$rules,Submission::$messages);

        if($valditor->fails()){
            return response()->json($valditor->errors(),404);
        }

        $submission->update($valditor->validated());
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
    public function destroy(Submission $submission)
    {
        $submission->delete();
        return response()->json($submission,200);
    }
}
