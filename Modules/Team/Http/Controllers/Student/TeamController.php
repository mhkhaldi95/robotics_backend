<?php

namespace Modules\Team\Http\Controllers\Student;

use Illuminate\Contracts\Support\Renderable;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller ;
use Modules\Team\Entities\Invitation;
use Modules\Team\Entities\Team;
use Modules\Team\Transformers\TeamResource;

class TeamController extends Controller
{

    public function __construct(Request $request)
    {
        parent::__construct($request);
        $this->middleware(['authorizor:students']);
    }

    public function index()
    {
        $teams = Team::all();
        return TeamResource::collection($teams);
    }

    public function create()
    {
        return view('team::create');
    }

    public function store(Request $request)
    {

    }

    public function show(Team $team)
    {
        $isInvitated = false;
        $invitation  = Invitation::where('team_id',$team->id)->where('to_student_id',$this->user->id)
        ->where('approved_at',null)->first();

        if($invitation != null){
            $isInvitated = true;
        }

        return response()->json([
            'team' => TeamResource::collection($team),
            'invitation' => $invitation,
            'isInvitated' =>$isInvitated
        ]);
    }

    public function edit($id)
    {
        return view('team::edit');
    }

    public function update(Request $request, Team $team)
    {
        //
    }

    public function destroy(Team $team)
    {
        //
    }
}
