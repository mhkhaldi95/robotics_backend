<?php

namespace Modules\Event\Http\Controllers\Student;

use Illuminate\Contracts\Support\Renderable;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller ;
use Modules\Event\Entities\Event;
use Modules\Event\Entities\Schedule;

class ScheduleController extends Controller
{
    public function __construct(Request $request)
    {
        parent::__construct($request);
        $this->middleware(['authorizor:students']);
    }

    public function index(Event $event)
    {
        if(!$this->user->hasTerm('read_event')){
            return response()->json([
                'success' => false,
                'message' => 'ليس لديك صلاحية لرؤية الفعاليات ، يرجى شراء باقة',
            ]);
        }
        if($event->approved_at != null){
            $schedules = $event->schedule;
            return response()->json($schedules);
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

    public function show(Event $event ,  Schedule $schedule)
    {
        if(!$this->user->hasTerm('read_event')){
            return response()->json([
                'success' => false,
                'message' => 'ليس لديك صلاحية لرؤية الفعاليات ، يرجى شراء باقة',
            ]);
        }
        if($event->approved_at != null){
            return response()->json($schedule);
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
