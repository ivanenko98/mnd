<?php

use App\Portal\Models\Role;
use App\Portal\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class AdminsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $user = User::create([
            'first_name' => 'Admin',
            'last_name' => 'Oleh',
            'email' => 'admin@gmail.com',
            'avatar' => 'https://i.pravatar.cc',
            'password' => Hash::make('123456'),
        ]);

        $role = Role::findByName('admin');
        $user->syncRoles($role);
    }
}
