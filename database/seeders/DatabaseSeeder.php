<?php

namespace Database\Seeders;

use AdminsTableSeeder;
use Illuminate\Database\Seeder;
use ManagersTableSeeder;
use RolesTableSeeder;
use ServicesTableSeeder;
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
        $this->call(UsersTableSeeder::class);
    }
}
