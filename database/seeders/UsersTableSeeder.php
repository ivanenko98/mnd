<?php

use App\Portal\Models\Roles\Manager;
use App\Portal\Models\Source\Role;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UsersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $managerRoleId = Role::getIdFromName('manager');

        $users = [
            [
                'email' => 'manager@gmail.com',
                'role_id' => $managerRoleId,
                'password' => Hash::make('123456'),
                'detail' => [
                    'first_name' => 'Manager',
                    'last_name' => 'Oleh',
                    'phone_number' => '+38-000-000-00-00',
                ]
            ]
        ];

        foreach ($users as $user_data) {
            if ($user_data['role_id'] == $managerRoleId) {
                $user = Manager::firstOrCreate(['email' => $user_data['email']], collect($user_data)->except('detail')->toArray());

                if (!$user->detail) {
                    $user->detail()->create($user_data['detail']);
                }
            }
        }
    }
}
