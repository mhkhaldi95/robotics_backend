<?php

namespace Modules\Training\Http\Controllers;

use Illuminate\Contracts\Support\Renderable;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Modules\Training\Entities\Course;
use Modules\Training\Entities\Section;
use Validator;


class SectionController extends Controller
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

        $valditor = Validator::make($request->all(), Section::$rules,Section::$messages);

        if($valditor->fails()){
            return response()->json($valditor->errors(),404);
        }

        $section = Section::create($valditor->validated());
        $course = $section->course;
        $course->sections()->save($section);

        return response()->json($section);
    }

    /**
     * Show the specified resource.
     * @param int $id
     * @return Renderable
     */
    public function show(Section $section)
    {
        return response()->json($section,200);
    }

    /**
     * Show the form for editing the specified resource.
     * @param int $id
     * @return Renderable
     */
    public function edit(Section $section)
    {
        return response()->json($section,200);
    }

    /**
     * Update the specified resource in storage.
     * @param Request $request
     * @param int $id
     * @return Renderable
     */
    public function update(Request $request, Section $section)
    {

        $valditor = Validator::make($request->all(), Section::$rules,Section::$messages);

        if($valditor->fails()){
            return response()->json($valditor->errors(),404);
        }

        $section->update($valditor->validated());
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
    public function destroy(Section $section)
    {
        $section->lessons()->delete();
        $section->delete();
        return response()->json($section,200);
    }
}
