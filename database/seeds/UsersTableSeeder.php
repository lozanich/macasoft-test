<?php

use Illuminate\Database\Seeder;
use Faker\Factory as Faker;

class UsersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $user = \App\User::where('full_name', 'admin')->count();
        $faker = Faker::create();
        if ($user <= 0) {
            \App\User::create([
                'full_name' => 'admin',
                'email' => 'admin@gmail.com',
                'password' => Hash::make('Admin.2019'),
                'id_rol' => 1,
                'user_photo' => $faker->image('public/storage/images', 400, 300, null, false),
                'api_token' => str_random(60),
            ]);
        }
        factory(\App\User::class, 10)->create();
    }
}
