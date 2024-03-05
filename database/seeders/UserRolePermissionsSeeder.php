<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class UserRolePermissionsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $permissions = [
            'view order history',
            'view order',
            'edit order',
            'delete order',
            'view meal'
        ];

        $role = Role::firstOrCreate(['name' => 'standard']);

        foreach($permissions as $permission) {

            $newPermission = Permission::firstOrCreate(['name' => $permission,  'guard_name' => 'web']);

            $newPermission->assignRole($role);
        }
    }
}
