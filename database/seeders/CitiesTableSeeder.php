<?php

use App\Portal\Models\City;
use App\Portal\Models\Role;
use App\Portal\Models\Service;
use App\Portal\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class CitiesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $cities = [
            'Poltava'
        ];

        foreach ($cities as $city) {
            City::create(['title' => $city]);
        }
    }
}
