<?php

namespace Modules\Team\Http\Controllers\Student;

use Illuminate\Contracts\Support\Renderable;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller ;
use App\Notifications\InvitationNotification;
use App\Student;
use Modules\Team\Entities\Invitation;
use Modules\Team\Entities\Team;

class InvitationStudentController extends Controller
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

    public function store(Request $request, Team $team, Student $student)
    {

        if($student->id == $this->user->id){
            return response()->json([
                'success' => false,
                'message' => 'انت عضو في هذا الفريق',
            ]);
        }

        if($this->user->teams->find($team) == null){
            return response()->json([
                'success' => true,
                'message' => 'أنت لست عضو في هذا الفريق',
            ]);
        }

        $invite =  Invitation::where('to_student_id',$student->id)->where('team_id',$team->id)->where('approved_at',null)->get();
        if(count($invite) != 0){
            return response()->json([
                'success' => true,
                'message' => 'u are invite already '.$student->first_name.' to join into team '.$team->name.'',
            ]);
       }



        $invitation = Invitation::create([
            'team_id' => $team->id,
            'to_student_id' => $student->id,
            'from_student_id' => $this->user->id,
        ]);

        //send notification
        $student->notify(new InvitationNotification($team , $this->user , $student));

        return response()->json([
            'success' => true,
            'message' => 'u are invite '.$student->first_name.' to join into team '.$team->name,
            'teams' => $invitation
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

    public function destroy($id)
    {
        //
    }
}
