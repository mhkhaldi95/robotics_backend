<?php

namespace App\Console\Commands;

use App\Student;
use Carbon\Carbon;
use DateTimeZone;
use Illuminate\Console\Command;
use Modules\Store\Entities\PackageSubscriptions;
use Modules\Store\Entities\PackageSubscriptionsItem;
use Modules\Store\Entities\TermStudent;

class TestCron extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'test:cron';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        $packageSubscriptions = PackageSubscriptions::where('expired',null)->get();
            foreach($packageSubscriptions as $packageSubscription){
                if($packageSubscription->expiration_at <= Carbon::now(new DateTimeZone('Asia/riyadh'))){
                    $packageSubscription->update([
                        'expired'=>1,
                    ]);

                     $student = Student::find($packageSubscription->student_id);
                     $packageItem = PackageSubscriptionsItem::find($packageSubscription->package_subscriptions_item_id);
                     $terms = $packageItem->package->terms;
                     foreach ($terms as $term){
                         $term_student = TermStudent::where('student_id',$student->id)->where('package_subscriptions_item_id',$packageItem->id)
                             ->where('term_id',$term->id)->first();
                         $term_student->delete();
                     }

                }
            }

    }
}
