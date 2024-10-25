<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class StadiumSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('stadiums')->insert([
            'name' => 'barnabeu',

        ]);
        DB::table('stadiums')->insert([
            'name' => 'old traford',

        ]);
    }
}
