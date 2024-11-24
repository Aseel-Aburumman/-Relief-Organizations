<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;
use App\Models\User;
use App\Models\Organization;

class RoleAndPermissionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {

        // Check and create roles
        $adminRole = Role::firstOrCreate(['name' => 'admin']);
        $donerRole = Role::firstOrCreate(['name' => 'doner']);
        $orgnizationRole = Role::firstOrCreate(['name' => 'orgnization']);

        // Check and create permissions for orders
        Permission::firstOrCreate(['name' => 'create neeed']);
        Permission::firstOrCreate(['name' => 'add to need']);
        Permission::firstOrCreate(['name' => 'view need']);
        Permission::firstOrCreate(['name' => 'manage needs']);
        Permission::firstOrCreate(['name' => 'CRUD need']);


        // Assign order permissions to roles
        $orgnizationRole->givePermissionTo(['CRUD need', 'view need']);
        $adminRole->givePermissionTo(['CRUD need', 'view need']);
        $donerRole->givePermissionTo(['view need']);

        $user = User::find(1);
        if ($user) {
            $user->assignRole($adminRole);
        }
        $user2 = User::find(2);
        if ($user2) {
            $user2->assignRole($donerRole);
        }
        $user3 = User::find(3);
        if ($user3) {
            $user3->assignRole($donerRole);
        }


        $organization = User::find(4);
        if ($organization) {
            $organization->assignRole($orgnizationRole);
        }
        $organization2 = User::find(5);
        if ($organization2) {
            $organization2->assignRole($orgnizationRole);
        }
        $organization3 = User::find(6);
        if ($organization3) {
            $organization3->assignRole($orgnizationRole);
        }
    }
}
