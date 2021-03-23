<?php

use App\Portal\Models\Role;
use Illuminate\Database\Seeder;

class RolesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $roles = [
            'manager',
        ];

        foreach ($roles as $role) {
            $data = [ 'name' => $role ];
            Role::firstOrCreate($data, $data);
        }
    }
}
