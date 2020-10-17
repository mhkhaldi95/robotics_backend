<?php

namespace Modules\Training\Http\Controllers\Student;

use Carbon\Carbon;
use DateTimeZone;
use Illuminate\Contracts\Support\Renderable;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller ;
use Modules\Store\Entities\Order;
use Modules\Store\Entities\Purchase;
use Modules\Store\Http\Controllers\Student\PackageStudentController;
use Modules\Training\Entities\Course;

class CoursePurchaseController extends Controller
{

    public function __construct(Request $request)
    {
        parent::__construct($request);
        $this->middleware(['authorizor:students']);
    }

    public function index()
    {
        return view('training::index');
    }

    /**
     * Show the form for creating a new resource.
     * @return Renderable
     */
    public function create()
    {
        return view('training::create');
    }

    /**
     * Store a newly created resource in storage.
     * @param Request $request
     * @return Renderable
     */
    public function store(Request $request ,Course $courseItem)
    {
        if(!$this->user->hasTerm('subscribe_course')){
            return response()->json([
                'error' =>[
                    'en' =>'You cannot proceed before subscribing to the Al Joud Package',
                    'ar' => 'لا يمكنك المتابعة قبل الاشتراك في باقة الجود'
                ],
            ]);
        }

        if($this->user->subscribedCourse($courseItem)){
            return response()->json([
                'error' =>[
                    'en' =>'You are a participant in this course',
                    'ar' => 'أنت مشترك في هذا الكورس'
                ],
            ]);
        }

        $item = $courseItem->item;
        $order = Order::create([]);
        $this->user->orders()->save($order);

        $purchase = Purchase::create([
            'price_unit' => $item->price
        ]);

        $this->user->purchases()->save($purchase);
        $order->purchases()->save($purchase);
        $item->purchase()->save($purchase);

        if($this->user->age < 15){
            return response()->json([
                'package' => $courseItem,
                'success' =>[
                    'en' =>'A notice has been sent to your father to agree to this procedure',
                    'ar' => 'تم ارسال اشعار لولي الأمر للموافقة على هذا الاجراء'
                ],
            ]);
        }

        $purchase->update([
            'approved_at' => Carbon::now(new DateTimeZone('Asia/riyadh')),
        ]);

        $result =  CourseStudentController::store($request,$courseItem);

        return response()->json([
            'result' => $result
        ]);
    }

    /**
     * Show the specified resource.
     * @param int $id
     * @return Renderable
     */
    public function show($id)
    {
        return view('training::show');
    }

    /**
     * Show the form for editing the specified resource.
     * @param int $id
     * @return Renderable
     */
    public function edit($id)
    {
        return view('training::edit');
    }

    /**
     * Update the specified resource in storage.
     * @param Request $request
     * @param int $id
     * @return Renderable
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     * @param int $id
     * @return Renderable
     */
    public function destroy($id)
    {
        //
    }
}
