<?php

namespace Modules\Store\Http\Controllers\Student;

use Cartalyst\Stripe\Laravel\Facades\Stripe;
use DateTimeZone;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller ;
use Carbon\Carbon;
use Modules\Store\Entities\Order;
use Modules\Store\Entities\PackageSubscriptions;
use Modules\Store\Entities\PackageSubscriptionsItem;
use Modules\Store\Entities\Purchase;
use MongoDB\Driver\Exception\Exception;

class PackagePurchaseController extends Controller
{

    public function __construct(Request $request)
    {
        parent::__construct($request);
        $this->middleware(['authorizor:students']);
    }

    public function index()
    {
        return view('store::index');
    }

    public function create()
    {
        return view('store::create');
    }

    public function store(Request $request, PackageSubscriptionsItem $packageItem)
        {

        if($this->user->subscribedPackage($packageItem)){
            return response()->json([
                'error' =>[
                    'en' =>'You have subscribed to this package before',
                    'ar' => 'لقد قمت بالاشتراك بهذه الباقة من قبل'
                ],
            ]);
        }
//            $charge = Stripe::charges()->create([
//                'currency'=>'USD',
//                'source'=>$request->stripeToken,
//                'amount'=>$request->paymentMethod,
//            ]);

//        $user = auth()->user();
//        $input = $request->all();
//        $token =  $request->stripeToken;
//        $paymentMethod = $request->paymentMethod;
//        try {
//
//            Stripe::setApiKey(env('STRIPE_SECRET'));
//
//            if (is_null($user->stripe_id)) {
//                $stripeCustomer = $user->createAsStripeCustomer();
//            }
//
//            \Stripe\Customer::createSource(
//                $user->stripe_id,
//                ['source' => $token]
//            );
//
//            $user->newSubscription('test',$input['plane'])
//                ->create($paymentMethod, [
//                    'email' => $user->email,
//                ]);
//
//            return response()->json('true');
//        } catch (Exception $e) {
//            return response()->json('false');
//        }



//        $stripe = new \Stripe\StripeClient('sk_test_51HYrloK3q59fOAnTlgQXIfgm6mTCanzjymytgPjTNwiqtiNtrkGpFh3ttzupQlrzvWOPXTQHwq9EeQsTciXyWWNj00SlGuN5w8');
//        $stripe->tokens->create([
//            'bank_account' => [
//                'country' => 'US',
//                'currency' => 'usd',
//                'account_holder_name' => 'Jenny Rosen',
//                'account_holder_type' => 'individual',
//                'routing_number' => '110000000',
//                'account_number' => '000123456789',
//            ],
//        ]);

        $item = $packageItem->item;
//////            $charge = Stripe::charges()->create([
//////                'currency'=>'USD',
//////                'source'=> $stripe->tokens,
//////                'amount'=>$request->paymentMethod,
//////            ]);



            $order = Order::create([]);
        $this->user->orders()->save($order);

        $purchase = Purchase::create([
            'price_unit' => $item->price,
        ]);

        $this->user->purchases()->save($purchase);
        $order->purchases()->save($purchase);
        $item->purchase()->save($purchase);

        if($this->user->age < 15){
            return response()->json([
                'package' => $packageItem,
                'success' =>[
                    'en' =>'A notice has been sent to your father to agree to this procedure',
                    'ar' => 'تم ارسال اشعار لولي الأمر للموافقة على هذا الاجراء'
                ],
            ]);
        }

        $purchase->update([
            'approved_at' => Carbon::now(new DateTimeZone('Asia/riyadh')),
        ]);
        $result =  PackageStudentController::store($request,$packageItem);

        return response()->json([
            'result' => $result
        ]);
    }

    public function show($id)
    {
        return view('store::show');
    }

    public function edit($id)
    {
        return view('store::edit');
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
