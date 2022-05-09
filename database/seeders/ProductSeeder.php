<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ProductSeeder extends Seeder
{
    public function run()
    {
        DB::table('products')->insert([
            'name' => 'Test product insert',
            'quantity' => 99,
            'price' => "99,99"
        ]);
    }
}
