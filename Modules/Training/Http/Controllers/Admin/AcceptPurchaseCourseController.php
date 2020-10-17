<?php

namespace Modules\Training\Http\Controllers\Admin;

use Carbon\Carbon;
use DateTimeZone;
use Illuminate\Contracts\Support\Renderable;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller ;
use App\Student;
use Modules\Store\Entities\Purchase;
use Modules\Training\Entities\Course;
use Modules\Training\Http\Controllers\Student\CourseStudentController;

class AcceptPurchaseCourseController extends Controller
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
    public function store(Request $request, Purchase $purchase)
    {
        $purchase->update([
            'approved_at' => Carbon::now(new DateTimeZone('Asia/riyadh')),
        ]);

        $courseItem = $purchase->item->details;
        $student = $purchase->student;

        $result =  CourseStudentController::store($request,$courseItem,$student);

        return response()->json([
            'post' => $result
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
    public function destroy(Course $course , Student $student)
    {
    }
}
