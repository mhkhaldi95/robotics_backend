<?php

namespace Modules\Training\Http\Controllers\Trainer;

use Illuminate\Contracts\Support\Renderable;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Modules\Store\Entities\Item;
use Modules\Training\Entities\Course;

class CourseTrainerController extends Controller
{

    public function __construct(Request $request)
    {
        parent::__construct($request);
        $this->middleware(['authorizor:trainers']);
    }

    public function index()
    {
        $courses = $this->user->courses;
        return response()->json($courses);
    }

    public function create()
    {
    }

    public function store(Request $request)
    {
        $valditor = Validator::make($request->all(), Course::$rules,Course::$messages);

        if($valditor->fails()){
            return response()->json($valditor->errors(),404);
        }

        $course = Course::create($valditor->validated());
        $trainer =$this->user;
        $trainer->courses()->save($course);

        $item = Item::create([
            'price' => $request->input('price'),
        ]);

        $course->item()->save($item);

        return response()->json([
            'success' => true,
            'message' => 'sucess',
            'course' => $course
        ]);
    }

    public function show(Course $course)
    {
        if($this->user->owns($course)){
            return response()->json([
                'success' => true,
                'message' => 'sucess',
                'course' => $course
            ]);
        }else {
            return response()->json([
                'success' => false,
                'message' => 'Not Authorize',
            ]);
        }
    }

    public function edit(Course $course)
    {
        if($this->user->owns($course)){
            return response()->json([
                'success' => true,
                'message' => 'sucess',
                'course' => $course
            ]);
        }else {
            return response()->json([
                'success' => false,
                'message' => 'Not Authorize',
            ]);
        }
    }

    public function update(Request $request, Course $course)
    {
        $valditor = Validator::make($request->all(), Course::$rules,Course::$messages);

        if($this->user->owns($course)){
            $course->update($valditor->validated());
            return response()->json([
                'success' => true,
                'message' => 'sucess',
                'course' => $course
            ]);
        }else {
            return response()->json([
                'success' => false,
                'message' => 'not authorize',
            ]);
        }
    }

    public function destroy(Course $course)
    {
        if($this->user->owns($course)){
            $course->sections()->delete();
            $course->lessons()->delete();
            $course->exam()->delete();
            $course->assignments()->delete();
            $course->certifications()->delete();
            $course->evaluations()->delete();
            $course->item()->delete();
            $course->delete();

            return response()->json([
                'success' => true,
                'message' => 'sucess',
                'course' => $course
            ]);
        }else {
            return response()->json([
                'success' => false,
                'message' => 'not authorize',
            ]);
        }

    }
}
