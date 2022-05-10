<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class AdminSeeder extends Seeder
{
    public function run()
    {
        DB::table('users')->insert([
            'name'      => 'Administrator',
            'password'  => bcrypt('admin'),
            'email'     => 'admin@admin.com',
        ]);
    }
}
