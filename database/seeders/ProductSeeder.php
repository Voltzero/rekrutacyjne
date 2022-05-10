<?php

namespace Database\Seeders;

use Faker\Factory;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ProductSeeder extends Seeder
{
    public function run()
    {
        $faker = Factory::create();

        for ($i = 0; $i < 50; $i++) {
            DB::table('products')->insert([
                'name' => $faker->word(),
                'quantity' => $faker->numberBetween(2, 100),
                'price' => $faker->numerify('%%.%#'),
                'code' => $faker->numerify('##########'),
                'created_at' => now(),
                'updated_at' => now()
            ]);
        }
    }
}
