<?php

use App\Portal\Models\City;
use App\Portal\Models\Order;
use App\Portal\Models\Role;
use App\Portal\Models\Service;
use App\Portal\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class OrdersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Order::factory()->count(5)->create();
    }
}
