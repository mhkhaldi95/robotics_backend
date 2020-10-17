<?php

namespace Modules\Team\Http\Controllers\Admin;

use Illuminate\Contracts\Support\Renderable;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller ;
use App\Student;
use Modules\Team\Entities\Team;

class TeamStudentController extends Controller
{
    public function __construct(Request $request)
    {
        parent::__construct($request);
        $this->middleware(['authorizor:admins']);
    }

    public function index()
    {
        return view('team::index');
    }

    public function create()
    {
        return view('team::create');
    }

    public function store(Request $request , Team $team , Student $student)
    {
        if(Team::find($team) && $team->students->find($student)){
            return response()->json([
                'success' => false,
                'message' => 'هذا الطالب موجود في هذا الفريق'
            ]);
        }

        $team->students()->attach($student);
        return response()->json([
            'success' => true,
            'message' => 'تم اضافة الطالب للفريق بنجاح',
            'team' => $team,
            'student' => $student
        ]);
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

    public function destroy(Team $team, Student $student, Student $newLeader = null)
    {
        if($student->id == $team->leader_id){
            if(count($team->students) == 1){
                $team->students()->detach();
                $team->delete();
                return response()->json([
                    'success' => true,
                    'message' => 'تم حذف الفريق بأكمله ،لأنه فقط في الفريق',
                    'team' => $team,
                    'student' => $student
                ]);
            }else{
                if($newLeader == null){
                    return response()->json([
                        'success' => false,
                        'message' => 'لا يمكنك حذف القائد ، قبل تحديد قائد بديل',
                    ]);
                }
                    $student->teams()->detach($team);
                    $team->update([
                        'leader_id' => $newLeader->id,
                    ]);
                    return response()->json([
                        'success' => true,
                        'message' => 'تم اضافة قائد جديد للفريق',
                        'team' => $team,
                        'new leader' => $newLeader
                    ]);
                }
        }

        if(Team::find($team) && $team->students->find($student)){
            $student->teams()->detach($team);
            return response()->json([
                'success' => true,
                'message' => 'تم حذف الطالب من الفريق بنجاح',
                'team' => $team,
                'student' => $student
            ]);
        }

        return response()->json([
            'success' => false,
            'message' => 'الطالب غير موجود في هذا الفريق'
        ]);

    }
}
