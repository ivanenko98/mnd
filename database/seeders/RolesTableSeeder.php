<?php

use App\Portal\Helpers\Acl;
use App\Portal\Models\Permission;
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
        foreach (Acl::roles() as $role) {
            Role::findOrCreate($role);
        }

        $adminRole = Role::findByName(Acl::ROLE_ADMIN);
        $managerRole = Role::findByName(Acl::ROLE_MANAGER);
        $masterRole = Role::findByName(Acl::ROLE_MASTER);

        foreach (Acl::permissions() as $permission) {
            Permission::findOrCreate($permission, 'api');
        }

        // Setup basic permission
        $adminRole->givePermissionTo(Acl::permissions());

        $managerRole->givePermissionTo(Acl::permissions([Acl::PERMISSION_PERMISSION_MANAGE, Acl::PERMISSION_MANAGERS_MANAGE]));

        $masterRole->givePermissionTo(Acl::menuPermissions());
        $masterRole->givePermissionTo(Acl::PERMISSION_ARTICLE_MANAGE);
    }
}
