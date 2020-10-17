<?php

namespace Modules\Training\Http\Controllers\admin;

use App\Image;
use Illuminate\Contracts\Support\Renderable;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Modules\Training\Entities\Course;
use Modules\Training\Entities\Lesson;
use Modules\Training\Entities\Section;

class SectionLessonController extends Controller
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
    public function store(Request $request,Section $section)
    {

        $rules =[
            'title'=>'required',
            'content' => 'required|mimetypes:video/x-ms-asf,video/x-flv,video/mp4,application/x-mpegURL,video/MP2T,video/3gpp,video/quicktime,video/x-msvideo,video/x-ms-wmv,video/avi'
        ];
        $valditor = Validator::make($request->all(), $rules);

        if($valditor->fails()){
            return response()->json($valditor->errors(),401);
        }

        $course = $section->course;
            $lessonTitle = time().'.'.$request->Content->getClientOriginalName();
            $request->Content->move(public_path('/uploads/Course/'.$course->name.'/'.$section->name.''), $lessonTitle);
            $lesson = Lesson::create([
                'title'=>$request->title,
                'content'=>$lessonTitle,

            ]);
        $section->lessons()->save($lesson);
        return response()->json([
            'success' =>[
                'en' =>'add done',
                'ar' => 'تم اضافة هذا الدرس بنجاح'
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
