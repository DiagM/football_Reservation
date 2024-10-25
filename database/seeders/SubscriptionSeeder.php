<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class SubscriptionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('subscriptions')->insert([
            'name' => 'Séance libre',
            'details' => 'some details here',
            'price' => '8000',
            'stadium_id' => '1',
            'subscriptionFrequency' => '1',
            'booking_choice' => '1',

        ]);
    }
}
