<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class TrainerSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        for($i = 1 ; $i<=10;$i++){
            DB::table('trainers')->insert([
                'user_name' => Str::random(5),
                'first_name' => Str::random(5),
                'second_name' => Str::random(5),
                'last_name' => Str::random(5),
                'email' => Str::random(5).'@gmail.com',
                'password' => Hash::make(123),
            ]);
        }

        DB::table('organizers')->insert([
            'user_name' => Str::random(5),
            'first_name' => Str::random(5),
            'second_name' => Str::random(5),
            'last_name' => Str::random(5),
            'email' => 'org@gmail.com',
            'password' => Hash::make(123),
        ]);
    }
}
