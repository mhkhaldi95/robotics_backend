<?php

namespace Modules\Event\Http\Controllers\Student;

use Illuminate\Contracts\Support\Renderable;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller ;
use Modules\Event\Entities\Context;
use Modules\Event\Entities\Schedule;

class ContextController extends Controller
{
    public function __construct(Request $request)
    {
        parent::__construct($request);
        $this->middleware(['authorizor:students']);
    }

    public function index(Schedule $schedule)
    {
        if(!$this->user->hasTerm('read_event')){
            return response()->json([
                'success' => false,
                'message' => 'ليس لديك صلاحية لرؤية الفعاليات ، يرجى شراء باقة',
            ]);
        }
        if($schedule->event->approved_at != null){
            $contexts = $schedule->contexts;
            return response()->json($contexts);
        }
        return response()->json([
            'success' => false,
            'message' => 'هذه الفعالية غير موافقة عليها بعد'
        ]);
    }

    public function create()
    {
        return view('event::create');
    }

    public function store(Request $request)
    {
        //
    }

    public function show(Schedule $schedule , Context $context)
    {
        if(!$this->user->hasTerm('read_event')){
            return response()->json([
                'success' => false,
                'message' => 'ليس لديك صلاحية لرؤية الفعاليات ، يرجى شراء باقة',
            ]);
        }
        if($schedule->event->approved_at != null){
            return response()->json($context);
        }
        return response()->json([
            'success' => false,
            'message' => 'هذه الفعالية غير موافقة عليها بعد'
        ]);
    }

    public function edit($id)
    {
        return view('event::edit');
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
