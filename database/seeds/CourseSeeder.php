<?php

use Carbon\Carbon;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Modules\Store\Entities\Item;
use Modules\Training\Entities\Course;
use Modules\Training\Entities\Exam;

class CourseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        for($i= 1 ; $i<=10 ; $i++){
            $course = Course::create([
                'name' => 'course'.$i,
                'description' => 'course'.$i,
                'hours' => $i,
                'trainer_id' => random_int(1,10),
           ]);
//            for($j= 1 ; $j<=10 ; $j++){
//                \Modules\Training\Entities\Question::create([
//                    'content'=>'quastion'.$j,
//                    'course_id'=>$i
//                ]);
//                \Modules\Training\Entities\Answer::create([
//                    'content'=>'answer'.$j,
//                    'question_id'=>$j
//                ]);
//            }


            $item = Item::create([
                'price' => 10,
                'approved_at' => Carbon::now(new DateTimeZone('Asia/riyadh')),
            ]);

            $course->item()->save($item);
        }

    }
}
