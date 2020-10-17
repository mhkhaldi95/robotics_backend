<?php

namespace Modules\Event\Http\Controllers\Admin;

use Illuminate\Contracts\Support\Renderable;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller ;
use Modules\Event\Entities\Context;
use Modules\Event\Entities\Schedule;
use Validator;

class ContextController extends Controller
{
    public function __construct(Request $request)
    {
        parent::__construct($request);
        $this->middleware(['authorizor:admins']);
    }

    public function index(Schedule $schedule)
    {
        $contexts = $schedule->contexts;
        return response()->json([
            'success' => true,
            'contexts' => $contexts
        ]);
    }

    public function create()
    {
    }

    public function store(Request $request , Schedule $schedule)
    {
        $valditor = Validator::make($request->all(), Context::$rules,Context::$messages);

        if($valditor->fails()){
            return response()->json($valditor->errors(),404);
        }

        $context = Context::create([
            'name' => $request->input('name'),
            'content' => $request->input('content'),
            'start' => $request->input('start'),
            'finish' => $request->input('finish'),
        ]);

        $context->schedule_id = $schedule->id;
        $schedule->contexts()->save($context);

        return response()->json([
            'success' => true,
            'message' => 'sucess',
            'context' => $context
        ]);
    }

    public function show(Schedule $schedule, Context $context)
    {
        return response()->json($context);
    }

    public function edit(Schedule $schedule, Context $context)
    {
        return response()->json($context);
    }

    public function update(Request $request, Context $context)
    {
        $valditor = Validator::make($request->all(), Context::$rules,Context::$messages);

        $context->update($valditor->validated());
            return response()->json([
                'success' => true,
                'message' => 'sucess',
                'context' => $context
        ]);
    }

    public function destroy(Schedule $schedule , Context $context)
    {
        $schedule->contexts()->delete($context);
        return response()->json([
            'success' => true,
            'message' => 'sucess',
            'context' => $context
        ]);
    }
}
