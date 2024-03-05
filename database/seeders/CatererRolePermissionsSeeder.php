<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class CatererRolePermissionsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $permissions = [
            'create meal',
            'edit meal',
            'delete meal',
            'view orders',
            'view finances'
        ];

        $role = Role::firstOrCreate(['name' => 'Caterer']);

        foreach($permissions as $permission) {

            $newPermission = Permission::firstOrCreate(['name' => $permission,  'guard_name' => 'api']);

            $newPermission->assignRole($role);
        }
    }
}
