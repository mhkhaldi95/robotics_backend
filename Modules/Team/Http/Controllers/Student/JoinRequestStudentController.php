<?php

namespace Modules\Team\Http\Controllers\Student;

use Illuminate\Contracts\Support\Renderable;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller ;
use Modules\Team\Entities\JoinRequest;
use Modules\Team\Entities\Team;

class JoinRequestStudentController extends Controller
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

    public function store(Request $request,Team $team)
    {
      if($this->user->teams->find($team)) {
          return response()->json([
              'success' => false,
              'message' => 'انت منضم لهذا الفريق',
          ]);
      }
        $joinRequest =  JoinRequest::where('from_student_id',$this->user->id)->where('to_team_id',$team->id)->where('approved_at',null)->get();
        if(count($joinRequest)!=0){
            return response()->json([
                'success' => false,
                'message' => 'لقد أرسلت طلبت انضمام من قبل',
            ]);
        }

        $joinRequest = JoinRequest::create([
            'to_team_id' => $team->id,
            'from_student_id' => $this->user->id,
        ]);

        return response()->json([
            'success' => true,
            'message' => 'تم ارسال طلب الانضمام',
            'teams' => $joinRequest
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
