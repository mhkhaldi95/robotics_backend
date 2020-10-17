<?php

use App\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class AdminSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {$user = \App\Admin::Create([
        'user_name' => 'robotics',
        'first_name' =>'robotics',
        'second_name' => 'robotics',
        'last_name' =>'robotics',
        'email' => 'robotics@gmail.com',
        'password' => Hash::make(123),
    ]);

    $user->attachRole('superadministrator');
    $permissions = DB::select( DB::raw("SELECT name FROM permissions") );
    foreach ($permissions as $per){
        $user->attachPermission($per->name);

    }

        for($i = 1 ; $i<=10;$i++){
           $user =   \App\Admin::Create([
                'user_name' => Str::random(5),
                'first_name' => Str::random(5),
                'second_name' => Str::random(5),
                'last_name' => Str::random(5),
                'email' => Str::random(5).'@gmail.com',
                'password' => Hash::make(123),
            ]);
            $user->attachRole('admin');
        }

    }
}
