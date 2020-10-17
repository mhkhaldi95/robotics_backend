<?php

namespace Modules\Team\Http\Controllers\Student;

use Carbon\Carbon;
use DateTimeZone;
use Illuminate\Contracts\Support\Renderable;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller ;
use Modules\Team\Entities\Invitation;
use Modules\Team\Entities\Team;

class AcceptInvitationStudentController extends Controller
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

    public function store(Request $request,Invitation $invitation)
    {
        if($this->user->invitations->find($invitation) && $invitation->approved_at == null){

            $invitation->approved_at = Carbon::now(new DateTimeZone('Asia/riyadh'));
            $invitation->save();
            $this->user->teams()->attach($invitation);

            return response()->json([
                'success' => true,
                'message' => 'تمت عملية الانضمام للفريق بنجاح',
            ]);
        }
        return response()->json([
        'success' => false,
        'message' => 'خطا',
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

    public function destroy(Invitation $invitation)
    {
        if($this->user->invitations->find($invitation) && $invitation->approved_at == null){
            $invitation->delete();
            return response()->json([
                'success' => true,
                'message' => 'تم حذف الدعوة',
            ]);
        }
        return response()->json([
            'success' => false,
            'message' => 'خطأ',
        ]);
    }
}
