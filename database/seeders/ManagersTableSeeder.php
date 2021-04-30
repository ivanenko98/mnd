<?php

use App\Portal\Models\Role;
use App\Portal\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class ManagersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $user = User::create([
            'first_name' => 'Manager',
            'last_name' => 'Oleh',
            'email' => 'manager@gmail.com',
            'password' => Hash::make('123456'),
        ]);

        $role = Role::findByName('manager');
        $user->syncRoles($role);
    }
}
