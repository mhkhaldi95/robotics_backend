<?php

namespace Modules\Research\Http\Controllers\Admin;

use Illuminate\Contracts\Support\Renderable;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller ;
use Carbon\Carbon;
use DateTimeZone;
use Modules\Research\Entities\Research;
use Validator;

class ResearchController extends Controller
{
    public function __construct(Request $request)
    {
        parent::__construct($request);
        $this->middleware(['authorizor:admins']);
    }

    public function index()
    {
        $research = Research::all();
        return response()->json($research);
    }


    public function create()
    {
    }

    public function store(Request $request)
    {
        $valditor = Validator::make($request->all(), Research::$rules,Research::$messages);

        if($valditor->fails()){
            return response()->json($valditor->errors(),404);
        }

        $research = Research::create([
            'name' => $request->input('name'),
            'description' => $request->input('description'),
            'approved_at' => Carbon::now(new DateTimeZone('Asia/riyadh')),
        ]);


        $this->user->researches()->save($research);

        return response()->json([
            'success' => true,
            'message' => 'sucess',
            'research' => $research
        ]);
    }

    public function show(Research $research)
    {
        return response()->json($research);
    }

    public function edit(Research $research)
    {
        return response()->json($research);
    }

    public function update(Request $request, Research $research)
    {
        $valditor = Validator::make($request->all(), Research::$rules,Research::$messages);

        $research->update($valditor->validated());
            return response()->json([
                'success' => true,
                'message' => 'sucess',
                'research' => $research
        ]);
    }

    public function destroy(Research $research)
    {
        $research->delete();
        return response()->json($research);
    }
}
