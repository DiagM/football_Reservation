<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;

class RoleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
{
    Role::create(['name' => 'UserManage', 'display_name' => 'Gérer les utilisateurs']);
    Role::create(['name' => 'SubscriptionManage', 'display_name' => 'Gérer les abonnements']);
    Role::create(['name' => 'StadiumManage', 'display_name' => 'Gérer les stades']);
    Role::create(['name' => 'FundManage', 'display_name' => 'Gérer la caisse']);
    Role::create(['name' => 'BookingManage', 'display_name' => 'Gérer les réservations']);
}

}
