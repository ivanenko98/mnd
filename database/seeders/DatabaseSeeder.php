<?php

namespace Database\Seeders;

use AdminsTableSeeder;
use CitiesTableSeeder;
use Illuminate\Database\Seeder;
use ManagersTableSeeder;
use MastersTableSeeder;
use OrdersTableSeeder;
use RolesTableSeeder;
use ServicesTableSeeder;
use SettingsTableSeeder;
use UsersTableSeeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        $this->call(ServicesTableSeeder::class);
        $this->call(RolesTableSeeder::class);
        $this->call(AdminsTableSeeder::class);
        $this->call(ManagersTableSeeder::class);
        $this->call(MastersTableSeeder::class);
        $this->call(UsersTableSeeder::class);
        $this->call(CitiesTableSeeder::class);
        $this->call(OrdersTableSeeder::class);
        $this->call(SettingsTableSeeder::class);
    }
}
