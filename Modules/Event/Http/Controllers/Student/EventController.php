<?php

namespace Modules\Event\Http\Controllers\Student;

use Illuminate\Contracts\Support\Renderable;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller ;
use Modules\Event\Entities\Event;

class EventController extends Controller
{
    public function __construct(Request $request)
    {
        parent::__construct($request);
        $this->middleware(['authorizor:students']);
    }

    public function index()
    {
        if(!$this->user->hasTerm('read_event')){
            return response()->json([
                'success' => false,
                'message' => 'ليس لديك صلاحية لرؤية الفعاليات ، يرجى شراء باقة',
            ]);
        }
        $events = Event::where('approved_at','!=',null)->get();
        return response()->json($events);
    }

    public function create()
    {
        return view('event::create');
    }

    public function store(Request $request)
    {
        //
    }

    public function show(Event $event)
    {
        if(!$this->user->hasTerm('read_event')){
            return response()->json([
                'success' => false,
                'message' => 'ليس لديك صلاحية لرؤية الفعاليات ، يرجى شراء باقة',
            ]);
        }
        return response()->json($event);
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
