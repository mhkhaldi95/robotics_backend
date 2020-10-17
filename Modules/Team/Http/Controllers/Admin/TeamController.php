<?php

namespace Modules\Team\Http\Controllers\Admin;

use App\Image;
use Illuminate\Contracts\Support\Renderable;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller ;
use App\Student;
use Modules\Team\Entities\Team;
use Modules\Team\Transformers\TeamResource;
use Validator;

class TeamController extends Controller
{
    public function __construct(Request $request)
    {
        parent::__construct($request);
        $this->middleware(['authorizor:admins'])->except('index');
    }

    public function index()
    {
        $teams =  Team::all();
        return response()->json(TeamResource::collection($teams),200);
    }

    public function create()
    {
        return view('team::create');
    }

    public function store(Request $request)
    {
        $rules = Team::$rules;
        $rules+= [
            'leader_id'=> 'required',
        ];

        $valditor = Validator::make($request->all(), $rules,Team::$messages);

        if($valditor->fails()){
            return response()->json($valditor->errors(),404);
        }

        $team = Team::create([
            'name' => $request->input('name'),
            'description' => $request->input('description'),
        ]);
        if($request->image){
            $imageName = time().'.'.$request->image->getClientOriginalName();
            $request->image->move(public_path('/uploads/image_team'), $imageName);
            $image = new \App\Image();
            $image->dsec_url =$imageName;
            $image->save();
            $team->image()->save($image);
        }else{
            $image = Image::create([]);
            $team->image()->save($image);
        }

        $user = Student::find($request->leader_id);
        $user->leaded_teams()->save($team);

        $user->teams()->attach($team);

        return response()->json([
            'success' =>[
                'en' =>'add done',
                'ar' => 'تمت الاضافة بنجاح'
            ],
            'team' => TeamResource::collection($team)
        ],200);
    }

    public function show(Team $team)
    {
        return response()->json(TeamResource::collection($team),200);
    }

    public function edit(Team $team)
    {
        return response()->json(TeamResource::collection($team),200);
    }

    public function update(Request $request, Team $team)
    {
        $valditor = Validator::make($request->all(), Team::$rules,Team::$messages);

        if($valditor->fails()){
            return response()->json($valditor->errors(),404);
        }

        $team->update($valditor->validated());
        return response()->json([
            'team' => TeamResource::collection($team),
            'success' =>[
                'en' =>'update done',
                'ar' => 'تم التعديل بنجاح'
            ],
        ],200);
    }

    public function destroy(Team $team)
    {
        $team->students()->detach();
        $team->invitations()->detach();
        $team->joinRequests()->delete();
        $team->delete();
        return response()->json([
            'team' => TeamResource::collection($team),
            'success' =>[
                'en' =>'delete done',
                'ar' => 'تم الحذف بنجاح'
            ],200]);
    }
}
