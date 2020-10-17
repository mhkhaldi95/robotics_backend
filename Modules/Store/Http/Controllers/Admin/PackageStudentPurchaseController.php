<?php

namespace Modules\Store\Http\Controllers\Admin;

use App\Student;
use Carbon\Carbon;
use DateTimeZone;
use Illuminate\Contracts\Support\Renderable;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller ;
use Modules\Store\Entities\Order;
use Modules\Store\Entities\PackageSubscriptionsItem;
use Modules\Store\Entities\Purchase;
use Modules\Store\Http\Controllers\Student\PackageStudentController;

class PackageStudentPurchaseController extends Controller
{
    public function __construct(Request $request)
    {
        parent::__construct($request);
        $this->middleware(['authorizor:admins']);
    }
    public function index()
    {
        return view('store::index');
    }

    /**
     * Show the form for creating a new resource.
     * @return Renderable
     */
    public function create()
    {
        return view('store::create');
    }

    /**
     * Store a newly created resource in storage.
     * @param Request $request
     * @return Renderable
     */
    public function store(Request $request,Student $student,PackageSubscriptionsItem $packageItem)
    {
        if($student->subscribedPackage($packageItem)){
            return response()->json([
                'error' =>[
                    'en' =>'You have subscribed to this package before',
                    'ar' => 'لقد قمت بالاشتراك بهذه الباقة من قبل'
                ],
            ]);
        }
//        $charge = Stripe::charges()->create([
//                'currency'=>'USD',
//                'source'=>$request->stripeToken,
//                'amount'=>$request->paymentMethod,
//            ]);
        $item = $packageItem->item;
        $order = Order::create([]);
        $this->user->orders()->save($order);

        $purchase = Purchase::create([
            'price_unit' => $item->price,
        ]);

        $student->purchases()->save($purchase);
        $order->purchases()->save($purchase);
        $item->purchase()->save($purchase);
        $purchase->update([
            'approved_at' => Carbon::now(new DateTimeZone('Asia/riyadh')),
        ]);
        $result =  PackageStudentController::store($request,$packageItem,$student);
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
        return view('store::show');
    }

    /**
     * Show the form for editing the specified resource.
     * @param int $id
     * @return Renderable
     */
    public function edit($id)
    {
        return view('store::edit');
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
