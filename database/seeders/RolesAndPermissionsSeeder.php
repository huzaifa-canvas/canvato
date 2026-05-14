<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;

class RolesAndPermissionsSeeder extends Seeder
{
    public function run(): void
    {
        // Reset cached roles and permissions
        app()[\Spatie\Permission\PermissionRegistrar::class]->forgetCachedPermissions();

        // ===========================
        // Define Permissions
        // ===========================

        // Dashboard
        $permissions = [
            // Dashboard
            'view dashboard',
            'view stats',

            // User Management
            'view users',
            'create users',
            'edit users',
            'delete users',
            'assign roles',

            // Role & Permission Management
            'view roles',
            'create roles',
            'edit roles',
            'delete roles',
            'view permissions',
            'create permissions',
            'edit permissions',
            'delete permissions',

            // Product/Item Management (Templates, PSDs, Plugins, etc.)
            'view products',
            'create products',
            'edit products',
            'delete products',
            'publish products',
            'unpublish products',

            // Category Management
            'view categories',
            'create categories',
            'edit categories',
            'delete categories',

            // Downloads & Files
            'download files',
            'upload files',
            'manage files',

            // Orders & Subscriptions
            'view orders',
            'manage orders',
            'view subscriptions',
            'manage subscriptions',

            // Settings
            'view settings',
            'manage settings',
        ];

        foreach ($permissions as $permission) {
            Permission::firstOrCreate(['name' => $permission]);
        }

        // ===========================
        // Define Roles & Assign Permissions
        // ===========================

        // Super Admin - Gets ALL permissions automatically via Gate::before in AuthServiceProvider
        $superAdmin = Role::firstOrCreate(['name' => 'Super Admin']);
        // Super Admin gets all permissions
        $superAdmin->givePermissionTo(Permission::all());

        // Admin - Almost everything except role/permission management
        $admin = Role::firstOrCreate(['name' => 'Admin']);
        $admin->givePermissionTo([
            'view dashboard', 'view stats',
            'view users', 'create users', 'edit users', 'delete users', 'assign roles',
            'view roles',
            'view products', 'create products', 'edit products', 'delete products', 'publish products', 'unpublish products',
            'view categories', 'create categories', 'edit categories', 'delete categories',
            'download files', 'upload files', 'manage files',
            'view orders', 'manage orders',
            'view subscriptions', 'manage subscriptions',
            'view settings', 'manage settings',
        ]);

        // Manager
        $manager = Role::firstOrCreate(['name' => 'Manager']);
        $manager->givePermissionTo([
            'view dashboard', 'view stats',
            'view users',
            'view products', 'create products', 'edit products', 'publish products', 'unpublish products',
            'view categories', 'create categories', 'edit categories',
            'download files', 'upload files', 'manage files',
            'view orders', 'manage orders',
        ]);

        // Contributor - Can create and edit their own products
        $contributor = Role::firstOrCreate(['name' => 'Contributor']);
        $contributor->givePermissionTo([
            'view dashboard',
            'view products', 'create products', 'edit products',
            'upload files',
            'download files',
        ]);

        // Designer
        $designer = Role::firstOrCreate(['name' => 'Designer']);
        $designer->givePermissionTo([
            'view dashboard',
            'view products', 'create products', 'edit products',
            'upload files',
            'download files',
        ]);

        // Developer
        $developer = Role::firstOrCreate(['name' => 'Developer']);
        $developer->givePermissionTo([
            'view dashboard',
            'view products', 'create products', 'edit products',
            'upload files',
            'download files',
        ]);

        // Customer - Can only browse and download purchased files
        $customer = Role::firstOrCreate(['name' => 'Customer']);
        $customer->givePermissionTo([
            'download files',
        ]);
    }
}
