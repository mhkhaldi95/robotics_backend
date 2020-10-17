<?php

namespace Modules\Event\Http\Controllers\Admin;

use Illuminate\Contracts\Support\Renderable;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller ;
use Carbon\Carbon;
use DateTimeZone;
use Modules\Event\Entities\Event;
use Modules\Event\Entities\Schedule;
use Validator;

class ScheduleController extends Controller
{
    public function __construct(Request $request)
    {
        parent::__construct($request);
        $this->middleware(['authorizor:admins']);
    }

    public function index(Event $event)
    {
        $schedules = $event->schedule;
        return response()->json([
            'success' => true,
            'schedule' => $schedules
        ]);
    }

    public function create()
    {
    }

    public function store(Request $request , Event $event)
    {
        if(Schedule::find($event->id)){
            return response()->json([
                'success' => false,
                'message' => 'يوجد لهذه الفعالية جدول خاص بها'
            ]);
        }
        $valditor = Validator::make($request->all(), Schedule::$rules,Schedule::$messages);

        if($valditor->fails()){
            return response()->json($valditor->errors(),404);
        }

        $schedule = Schedule::create([
            'description' => $request->input('description'),
        ]);

        $event->schedule()->save($schedule);

        return response()->json([
            'success' => true,
            'message' => 'sucess',
            'schedule' => $schedule
        ]);
    }

    public function show(Event $event , Schedule $schedule)
    {
        return response()->json($schedule);
    }

    public function edit(Event $event , Schedule $schedule)
    {
        return response()->json($schedule);
    }

    public function update(Request $request, Schedule $schedule)
    {
        $valditor = Validator::make($request->all(), Schedule::$rules,Schedule::$messages);

        $schedule->update($valditor->validated());
            return response()->json([
                'success' => true,
                'message' => 'sucess',
                'schedule' => $schedule
        ]);
    }

    public function destroy(Event $event , Schedule $schedule)
    {
        $schedule->contexts()->delete();
        $event->schedule()->delete($schedule);
        return response()->json([
            'success' => true,
            'message' => 'sucess',
            'schedule' => $schedule
        ]);

    }
}
