<?php

namespace Modules\Team\Http\Controllers\Student;

use App\Student;
use DateTimeZone;
use Illuminate\Contracts\Support\Renderable;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller ;
use Illuminate\Support\Carbon;
use Modules\Team\Entities\JoinRequest;
use Modules\Team\Entities\Team;

class AcceptJoinRequestStudentController extends Controller
{

    public function __construct(Request $request)
    {
        parent::__construct($request);
        $this->middleware(['authorizor:students']);
    }

    public function index()
    {
        return view('team::index');
    }

    public function create()
    {
        return view('team::create');
    }

    public function store(Request $request,JoinRequest $joinRequest)
    {

        $team = Team::find($joinRequest->to_team_id);
        $student = Student::find($joinRequest->from_student_id);


        $leader = $team->leader;

        if($this->user->id != $leader->id){
            return response()->json([
                'success' => false,
                'message' => 'ليس لك صلاحية للموافقة',
            ]);
        }

        if(JoinRequest::find($joinRequest) && $joinRequest->approved_at == null){
            $joinRequest->approved_at = Carbon::now(new DateTimeZone('Asia/riyadh'));
            $joinRequest->save();
            $team->students()->attach($student);
            return response()->json([
                'success' => true,
                'message' => 'تمت عملية الانضمام للفريق بنجاح',
            ]);
        }

    }

    public function show($id)
    {
        return view('team::show');
    }

    public function edit($id)
    {
        return view('team::edit');
    }

    public function update(Request $request, $id)
    {
        //
    }

    public function destroy(JoinRequest $joinRequest)
    {
        if(JoinRequest::find($joinRequest) && $joinRequest->approved_at == null){
            $joinRequest->delete();
            return response()->json([
                'success' => true,
                'message' => 'تم حذف الطلب',
            ]);
        }
        return response()->json([
            'success' => false,
            'message' => 'خطأ',
        ]);
    }
}
