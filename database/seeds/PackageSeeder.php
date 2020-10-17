<?php

use App\Models\Permission;
use Carbon\Carbon;
use Illuminate\Database\Seeder;
use Modules\Store\Entities\Item;
use Modules\Store\Entities\Package;
use Modules\Store\Entities\PackageSubscriptionsItem;
use Modules\Store\Entities\Subscription;
use Modules\Store\Entities\Term;

class PackageSeeder extends Seeder
{
    public function run()
    {
        for($i= 1 ; $i<=3 ; $i++){
            $package = Package::create([
                'name' => 'package'.$i,
                'description' => 'package'.$i,
           ]);


        }
        $type = ['month','year'];
        foreach($type as $t){
            $subscription = Subscription::create([
                'type' => $t
            ]);
        }



        foreach(Package::all() as $package){
            foreach(Subscription::all() as $subscription){
              $package->subscriptions()->attach($subscription);
            }
        }

        foreach(PackageSubscriptionsItem::all() as $psi){
            $item = Item::create([
                'price' => 10,
                'approved_at' => Carbon::now(new DateTimeZone('Asia/riyadh')),
                ]);
            $psi->item()->save($item);
        }
        $terms=[
            ['name.ar'=>'الاشتراك بالكورسات' ,'name.en'=>'subscribe_course' ],
            ['name.ar'=>'الأبحاث' ,'name.en'=>'researches' ],
        ];
        foreach ($terms as $term){
            $newTerm = new Term; // This is an Eloquent model
            $newTerm->setTranslation('name', 'ar', $term['name.ar'])
                ->setTranslation('name', 'en',$term['name.en'])
                ->save();
        }




        $terms = Term::all();
        $packages = Package::all();
        foreach($packages as $package){

            $package->terms()->attach($terms);


        }

    }
}
