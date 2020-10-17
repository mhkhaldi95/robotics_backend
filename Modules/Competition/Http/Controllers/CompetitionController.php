<?php

namespace Modules\Competition\Http\Controllers;

use App\Admin;
use Illuminate\Contracts\Support\Renderable;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\Auth;
use Modules\Competition\Entities\Competition;
use Validator;

class CompetitionController extends Controller
{
    /**
     * Display a listing of the resource.
     * @return Renderable
     */
    public function index()
    {
        $competitions = Competition::all();
        return response()->json($competitions,200);    }

    /**
     * Show the form for creating a new resource.
     * @return Renderable
     */
    public function create()
    {
        return view('competition::create');
    }

    /**
     * Store a newly created resource in storage.
     * @param Request $request
     * @return Renderable
     */
    public function store(Request $request)
    {
        $valditor = Validator::make($request->all(), Competition::$rules,Competition::$messages);

        if($valditor->fails()){
            return response()->json($valditor->errors(),404);
        }

        $competition = Competition::create($valditor->validated());
        $admin =Admin::find(Auth::id());
        $admin->competitions()->save($competition);

        return response()->json($competition);
    }

    /**
     * Show the specified resource.
     * @param int $id
     * @return Renderable
     */
    public function show(Competition $competition)
    {
        return response()->json($competition,200);
    }

    /**
     * Show the form for editing the specified resource.
     * @param int $id
     * @return Renderable
     */
    public function edit(Competition $competition)
    {
        return response()->json($competition,200);
    }

    /**
     * Update the specified resource in storage.
     * @param Request $request
     * @param int $id
     * @return Renderable
     */
    public function update(Request $request, Competition $competition)
    {
        $valditor = Validator::make($request->all(), Competition::$rules,Competition::$messages);

        if($valditor->fails()){
            return response()->json($valditor->errors(),404);
        }

        $competition->update($valditor->validated());
        return response()->json([
            'success' => true,
            'message' => 'sucess'
        ]);

    }

    /**
     * Remove the specified resource from storage.
     * @param int $id
     * @return Renderable
     */
    public function destroy(Competition $competition)
    {
        $competition->delete();
        return response()->json($competition,200);
    }
}
