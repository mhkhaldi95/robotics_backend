<?php

namespace Modules\Event\Http\Controllers\Admin;

use Illuminate\Contracts\Support\Renderable;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller ;
use App\Organizer;
use Carbon\Carbon;
use DateTimeZone;
use Modules\Event\Entities\Event;
use Modules\Store\Entities\Item;
use Validator;

class EventController extends Controller
{
    public function __construct(Request $request)
    {
        parent::__construct($request);
        $this->middleware(['authorizor:admins']);
    }

    public function index()
    {
        $events = Event::all();
        return response()->json($events);
    }

    public function create()
    {
    }

    public function store(Request $request)
    {
        $valditor = Validator::make($request->all(), Event::$rules,Event::$messages);

        if($valditor->fails()){
            return response()->json($valditor->errors(),404);
        }

        if($request->organizer_id == null){
            return \response()->json([
                'success' => false,
                'message' => 'يجب عليك اضافة صاحب فعالية لهذه الفعالية'
            ]);
        }

        if($request->price == null){
            return \response()->json([
                'success' => false,
                'message' => 'يجب عليك اضافة سعر لهذه الفعالية'
            ]);
        }


        $organizer_id = $request->organizer_id;

        $event = Event::create([
            'name' => $request->input('name'),
            'description' => $request->input('description'),
            'approved_at' => Carbon::now(new DateTimeZone('Asia/riyadh')),
            'organizer_id' => $organizer_id,
        ]);

        $event->organizer_id = $organizer_id;
        $event->save();

        $item = Item::create([
            'price' => $request->input('price'),
            'approved_at' => Carbon::now(new DateTimeZone('Asia/riyadh')),
        ]);

        $event->item()->save($item);

        return response()->json([
            'success' => true,
            'message' => 'sucess',
            'event' => $event
        ]);
    }

    public function show(Event $event)
    {
        return response()->json($event);
    }

    public function edit(Event $event)
    {
        return response()->json($event);
    }

    public function update(Request $request, Event $event)
    {
        $valditor = Validator::make($request->all(), Event::$rules,Event::$messages);

        $event->update($valditor->validated());
            return response()->json([
                'success' => true,
                'message' => 'sucess',
                'event' => $event
        ]);
    }

    public function destroy(Event $event)
    {
        $event->schedule->contexts()->delete();
        $event->schedule()->delete();
        $event->delete();

        return response()->json([
            'success' => true,
            'message' => 'sucess',
            'event' => $event
        ]);
    }
}
