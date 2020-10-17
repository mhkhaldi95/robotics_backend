<?php

namespace Modules\Training\Http\Controllers\admin;

use Illuminate\Contracts\Support\Renderable;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller ;
use Modules\Training\Entities\Course;
use Modules\Training\Entities\Section;
use Validator;

class CourseSectionController extends Controller
{
    public function __construct(Request $request)
    {
        parent::__construct($request);
        $this->middleware(['authorizor:admins']);
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
    public function store(Request $request,Course $course)
    {

        $rule = ['name' => 'required|string|max:255',];
        $valditor = Validator::make($request->all(), $rule);
        if($valditor->fails()){
            return response()->json($valditor->errors(),404);
        }
        $section = Section::create([
            'name'=>$request->name,
        ]);
        $course->sections()->save($section);
        return response()->json([
            'success' =>[
                'en' =>'add done',
                'ar' => 'تتم اضافة السيكشن بنجاح'
            ],
            'section' => $section
        ],200);
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
    public function destroy(Course $course , Section $section )
    {

        if($course->sections->find($section)){
            $section->lessons()->delete();
            $course->sections()->delete($section);
            return response()->json([
                'success' =>[
                    'en' =>'delete done',
                    'ar' => 'تم الحذف بنجاح'
                ],
                'section' => $section
            ],200);
        }
        return response()->json([
            'error' =>[
                'en' =>'The section you are trying to delete does not exist in the course',
                'ar' => 'السيكشن الذي تحاول حذفه غير موجود داخل الكورس'
            ],
            'section' => $section
        ],401);
    }
}
