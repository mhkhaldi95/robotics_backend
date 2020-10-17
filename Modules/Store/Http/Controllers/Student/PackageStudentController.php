<?php

namespace Modules\Store\Http\Controllers\Student;

use App\Models\Role;
use Carbon\Carbon;
use DateTimeZone;
use Illuminate\Contracts\Support\Renderable;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller ;
use Illuminate\Support\Facades\Auth;
use Modules\Store\Entities\Package;
use Modules\Store\Entities\PackageSubscriptions;
use Modules\Store\Entities\PackageSubscriptionsItem;
use Modules\Store\Entities\Purchase;
use Modules\Store\Transformers\PermissionResource;

class PackageStudentController extends Controller
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

    public static function store(Request $request , PackageSubscriptionsItem $packageItem, $student = null)
    {
        if($student == null){
            $user = Auth::guard($request->attributes->get("guard"))->user();
        }else{
            $user = $student;
        }

        $nameExpire = $packageItem->subscription->type;
        $user->packageSubscriptions()->attach($packageItem,[
            'started_at'=>Carbon::now(new DateTimeZone('Asia/riyadh')),
            'expiration_at' =>$nameExpire == 'month' ? Carbon::now(new DateTimeZone('Asia/riyadh'))->addMonth() : Carbon::now(new DateTimeZone('Asia/riyadh'))->addYear()
            ]);

        $package = Package::find($packageItem->package_id);

//        $terms = TermResource::collection($package->terms);
        $terms = $package->terms;
        $user->terms()->attach($terms,['package_subscriptions_item_id'=>$packageItem->id]);
        return response()->json([
            'packageItem' => $packageItem,
            'success' =>[
                'en' =>'Successful purchase',
                'ar' => 'تم الشراء بنجاح'
            ],
        ],200);
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
