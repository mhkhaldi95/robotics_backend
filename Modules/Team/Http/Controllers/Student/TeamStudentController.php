<?php

namespace Modules\Team\Http\Controllers\Student;

use App\Image;
use Illuminate\Contracts\Support\Renderable;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller ;
use Modules\Team\Entities\Team;
use Modules\Team\Transformers\TeamResource;
use Validator;

class TeamStudentController extends Controller
{
    public function __construct(Request $request)
    {
        parent::__construct($request);
        $this->middleware(['authorizor:students']);
    }

    public function index()
    {
        $teams = $this->user->teams;
        return response()->json(TeamResource::collection($teams));
    }

    public function store(Request $request)
    {
        $valditor = Validator::make($request->all(), Team::$rules,Team::$messages);

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

        $this->user->leaded_teams()->save($team);

        $this->user->teams()->attach($team);

        return response()->json([
            'success' => true,
            'message' => [
                'en' => 'Your team has been created',
                'ar' => 'تم انشاء الفريق الخاص بك'
            ],
            'team' => TeamResource::collection($team)
        ]);
    }

    public function show(Team $team)
    {
        if($this->user->teams->find($team)){
            return response()->json(TeamResource::collection($team),200) ;
        }
        return response()->json([
            'error' =>[
                'en' =>'You are not in this team',
                'ar' => 'هذا الفريق لست موجود به'
            ],
        ],401);

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
