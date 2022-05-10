<?php

namespace Database\Seeders;

use App\Models\User;
use Faker\Factory as Faker;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class UserSeeder extends Seeder
{
    public function run()
    {
        $faker = Faker::create();

        $faker->addProvider(new \Faker\Provider\pl_PL\Person($faker));

        DB::table('users')->insert([
            'name'      => $faker->firstName . ' ' . $faker->lastName,
            'password'  => bcrypt('password'),
            'email'     => 'user@user.com',
        ]);
    }
}
