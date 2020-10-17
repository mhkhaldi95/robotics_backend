<?php

use Illuminate\Database\Seeder;


class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
{
    //  factory(App\Student::class, 3)->create();
     $this->call([

         LaratrustSeeder::class,
         AdminSeeder::class,
         StudentSeeder::class,
         TrainerSeeder::class,
         PackageSeeder::class,
         CourseSeeder::class,
     ]);
}
}
