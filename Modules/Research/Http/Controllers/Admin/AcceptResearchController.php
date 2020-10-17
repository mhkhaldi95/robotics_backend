<?php

namespace Modules\Research\Http\Controllers\Admin;

use Illuminate\Contracts\Support\Renderable;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller ;
use Carbon\Carbon;
use DateTimeZone;
use Modules\Research\Entities\Research;

class AcceptResearchController extends Controller
{
    public function __construct(Request $request)
    {
        parent::__construct($request);
        $this->middleware(['authorizor:admins']);
    }

    public function index()
    {
        $researchs = Research::where('approved_at',null);
        return response()->json($researchs);
    }

    public function create()
    {
    }

    public function store(Request $request, Research $research)
    {
        if($research->approved_at != null){
            return response()->json([
                'success' => false,
                'message' => 'هذا البحث تمت الموافقة عليه',
                'research' => $research
            ]);
        }

        $research->update([
            'approved_at' => Carbon::now(new DateTimeZone('Asia/riyadh')),
        ]);

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

    public function update(Request $request, $id)
    {
        //
    }

    public function destroy($id)
    {
        //
    }
}
