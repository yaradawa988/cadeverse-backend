<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Faker\Factory as Faker;
use App\Models\User;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $faker = Faker::create();
        $users = [
            [
               'name'=>'user',
               'l_name'=>'user',
               'email'=>'user@gmail.com',
               'role'=> 0,
               'password'=> bcrypt('123456'),
               'university'=>'example',
          
             
            ],
            [
               'name'=>'admin',
               'l_name'=>'admin',
               'email'=>'admin@gmail.com',
               'role'=> 1,
               'password'=> bcrypt('123456'),
               'university'=>'example',
            
            ],
            
        ];
    
        foreach ($users as $key => $user) 
        {
            User::create($user);
        }
    }
}
