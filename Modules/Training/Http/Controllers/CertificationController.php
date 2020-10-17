<?php

namespace Modules\Training\Http\Controllers;

use Illuminate\Contracts\Support\Renderable;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Modules\Training\Entities\Certification;
use Validator;

class CertificationController extends Controller
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
        $valditor = Validator::make($request->all(), Certification::$rules,Certification::$messages);

        if($valditor->fails()){
            return response()->json($valditor->errors(),404);
        }

        $certification = Certification::create($valditor->validated());
        $course = $certification->course;
        $course->certifications()->save($certification);

        $student = $certification->student;
        $student->certifications()->save($certification);

        return response()->json($certification);

    }

    /**
     * Show the specified resource.
     * @param int $id
     * @return Renderable
     */
    public function show(Certification $certification)
    {
        return response()->json($certification,200);
    }

    /**
     * Show the form for editing the specified resource.
     * @param int $id
     * @return Renderable
     */
    public function edit(Certification $certification)
    {
        return response()->json($certification,200);
    }

    /**
     * Update the specified resource in storage.
     * @param Request $request
     * @param int $id
     * @return Renderable
     */
    public function update(Request $request, Certification $certification)
    {
        $valditor = Validator::make($request->all(), Certification::$rules,Certification::$messages);

        if($valditor->fails()){
            return response()->json($valditor->errors(),404);
        }

        $certification->update($valditor->validated());
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
    public function destroy(Certification $certification)
    {
        $certification->delete();
        return response()->json($certification,200);
    }
}
