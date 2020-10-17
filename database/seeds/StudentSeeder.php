<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class StudentSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('students')->insert([
            'user_name' => 'baraa',
            'first_name' => 'baraa',
            'second_name' => 'baraa',
            'last_name' => 'baraa',
//            'address' => 'baraa',
            'age' => 20,
            'email' => 'bmukayed'.'@gmail.com',
            'password' => Hash::make(123),
        ]);

        DB::table('students')->insert([
            'user_name' => 'ahmed',
            'first_name' => 'ahmed',
            'second_name' => 'ahmed',
            'last_name' => 'ahmed',
//            'address' => 'ahmed',
            'age' => 12,
            'email' => 'ahmed'.'@gmail.com',
            'password' => Hash::make(123),
        ]);

        for($i = 1 ; $i<=10;$i++){
            DB::table('students')->insert([
                'user_name' => Str::random(5),
                'first_name' => Str::random(5),
                'second_name' => Str::random(5),
                'last_name' => Str::random(5),
//                'address' => Str::random(5),
                'age' => 20,
                'email' => Str::random(5).'@gmail.com',
                'password' => Hash::make(123),
            ]);
        }
    }
}
