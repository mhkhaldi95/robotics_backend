<?php

namespace Modules\Store\Http\Controllers\Admin;

use Carbon\Carbon;
use DateTimeZone;
use Illuminate\Contracts\Support\Renderable;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller ;
use Modules\Store\Entities\Item;
use Modules\Store\Entities\Package;
use Modules\Store\Entities\PackageSubscriptionsItem;
use Modules\Store\Entities\Subscription;
use Validator;
class PackageController extends Controller
{
    public function __construct(Request $request)
    {
        parent::__construct($request);
        $this->middleware(['authorizor:admins'])->except(['index','show']);
    }
    public function index()
    {
        return response()->json(Package::all(),200);
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
    public function store(Request $request)
    {



        $valditor = Validator::make($request->all(), Package::$rules,Package::$messages);

        if($valditor->fails()){
            return response()->json($valditor->errors(),400);
        }


        $package = new Package; // This is an Eloquent model
            $package->setTranslation('name', 'ar', $request->name['ar'])
                ->setTranslation('name', 'en', $request->name['en'])
                ->setTranslation('description', 'ar', $request->description['ar'])
                ->setTranslation('description', 'en', $request->description['en'])
                ->save();


        foreach(Subscription::all() as $subscription){
                $package->subscriptions()->attach($subscription);
            }

        $price = $request->price; //array -- price['month'] month  price ['year'] year
        foreach(PackageSubscriptionsItem::where('package_id',$package->id)->get() as $index=>$psi){
            $item = Item::create([
                'price' => $index ==0?$price['month']:$price['year'],
                'approved_at' => Carbon::now(new DateTimeZone('Asia/riyadh')),
            ]);
            $psi->item()->save($item);
        }
        return response()->json([
            'package'=>$package,
            'success' =>[
                'en' =>'add done',
                'ar' => 'تمت الاضافة بنجاح'
            ],
        ],200);

    }

    /**
     * Show the specified resource.
     * @param int $id
     * @return Renderable
     */
    public function show(Package $package)
    {
        return response()->json($package,200);
    }

    /**
     * Show the form for editing the specified resource.
     * @param int $id
     * @return Renderable
     */
    public function edit(Package $package)
    {
        return response()->json($package,200);
    }

    /**
     * Update the specified resource in storage.
     * @param Request $request
     * @param int $id
     * @return Renderable
     */
    public function update(Request $request, Package $package)
    {

        $rulesUpdate = [
            'name.ar'=> 'required|unique:packages,name->ar,'.$package->id.'',
            'name.en'=> 'required|unique:packages,name->en,'.$package->id.'',
            'description.ar'=> 'required',
            'description.en'=> 'required',
            'price.month'=> 'required',
            'price.year'=> 'required',

        ];
        $valditor = Validator::make($request->all(), $rulesUpdate,Package::$messages);
        if($valditor->fails()){
            return response()->json($valditor->errors(),401);
        }
        $package->update($request->all());
        return response()->json([
            'package'=>$package,
            'success' =>[
                'en' =>'update done',
                'ar' => 'تم التعديل بنجاح'
            ],
        ],200);

    }


    public function destroy(Package $package)
    {

//        $package->terms()->delete();
        foreach ($package->subscriptions as $subscription){
            PackageSubscriptionsItem::where('package_id',$subscription->pivot->package_id)->where('subscription_id',$subscription->pivot->subscription_id)->delete();
        }

        $package->delete();
        return response()->json([
            'package'=>$package,
            'success' =>[
                'en' =>'delete done',
                'ar' => 'تم الحذف بنجاح'
            ],
        ],200);

    }
}
