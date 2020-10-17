<?php

namespace Modules\Research\Http\Controllers\Student;

use Illuminate\Contracts\Support\Renderable;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller ;
use Modules\Research\Entities\Research;
use Validator;

class ResearchController extends Controller
{
    public function __construct(Request $request)
    {
        parent::__construct($request);
        $this->middleware(['authorizor:students']);
    }

    public function index()
    {
        if(!$this->user->hasTerm('read_research')){
            return response()->json([
                'success' => false,
                'message' => 'ليس لديك صلاحية لقراءة الأبحاث ، يرجى شراء باقة',
            ]);
        }
        $researchs = Research::where('approved_at',null)->get();
        return response()->json($researchs);
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
        ]);

        $this->user->researches()->save($research);

        return response()->json([
            'success' => true,
            'message' => 'تم اقتراح الخبر الخاص بك',
            'research' => $research
        ]);
    }

    public function show(Research $research)
    {
        if(!$this->user->hasTerm('read_research')){
            return response()->json([
                'success' => false,
                'message' => 'ليس لديك صلاحية لقراءة الأبحاث ، يرجى شراء باقة',
            ]);
        }

        if($research->approved_at == null){
            return response()->json([
                'success' => false,
                'message' => 'هذا البحث لم يتم الموافقة عليه بعد',
            ]);
        }
        return response()->json($research);
    }

    public function edit($id)
    {
        return view('research::edit');
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
