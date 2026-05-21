<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;

class RoleSeeder extends Seeder
{
    public function run(): void
    {
        $permissions = [
            'products.view', 'products.create', 'products.edit', 'products.delete',
            'categories.view', 'categories.create', 'categories.edit', 'categories.delete',
            'orders.view', 'orders.edit', 'orders.export',
            'reviews.view', 'reviews.moderate',
            'contacts.view', 'contacts.delete',
            'users.view', 'users.edit',
            'settings.view', 'settings.edit',
            'media.upload', 'media.delete',
            'reports.view',
        ];

        foreach ($permissions as $perm) {
            Permission::firstOrCreate(['name' => $perm]);
        }

        $superAdmin = Role::firstOrCreate(['name' => 'super_admin']);
        $admin = Role::firstOrCreate(['name' => 'admin']);
        $staff = Role::firstOrCreate(['name' => 'staff']);

        $superAdmin->syncPermissions(Permission::all());
        $admin->syncPermissions(Permission::all());
        $staff->syncPermissions([]);
    }
}
