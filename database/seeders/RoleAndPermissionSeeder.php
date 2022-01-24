<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\PermissionRegistrar;

class RoleAndPermissionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // Reset cached roles and permissions
        app()[PermissionRegistrar::class]->forgetCachedPermissions();

        // Create permissions
        Permission::create(['name' => 'create users']);
        Permission::create(['name' => 'view users']);
        Permission::create(['name' => 'edit users']);
        Permission::create(['name' => 'delete users']);
        Permission::create(['name' => 'manage users']);

        Permission::create(['name' => 'manage permissions']);
        Permission::create(['name' => 'manage roles']);

        Permission::create(['name' => 'create buildings']);
        Permission::create(['name' => 'edit buildings']);
        Permission::create(['name' => 'delete buildings']);

        Permission::create(['name' => 'create floors']);
        Permission::create(['name' => 'edit floors']);
        Permission::create(['name' => 'delete floors']);

        Permission::create(['name' => 'create flats']);
        Permission::create(['name' => 'edit flats']);
        Permission::create(['name' => 'delete flats']);

        Permission::create(['name' => 'create partitions']);
        Permission::create(['name' => 'edit partitions']);
        Permission::create(['name' => 'delete partitions']);

        Permission::create(['name' => 'create cards']);
        Permission::create(['name' => 'edit cards']);
        Permission::create(['name' => 'delete cards']);

        Permission::create(['name' => 'create tenants']);
        Permission::create(['name' => 'edit tenants']);
        Permission::create(['name' => 'delete tenants']);

        Permission::create(['name' => 'create referrers']);
        Permission::create(['name' => 'edit referrers']);
        Permission::create(['name' => 'delete referrers']);

        Permission::create(['name' => 'manage settings']);

        Permission::create(['name' => 'create cardreceipts']);
        Permission::create(['name' => 'edit cardreceipts']);
        Permission::create(['name' => 'delete cardreceipts']);

        Permission::create(['name' => 'create invoices']);
        Permission::create(['name' => 'edit invoices']);
        Permission::create(['name' => 'delete invoices']);

        Permission::create(['name' => 'create paybalances']);
        Permission::create(['name' => 'edit paybalances']);
        Permission::create(['name' => 'delete paybalances']);

        // Create roles and assign existing permissions
        $super_admin = Role::create(['name' => 'super-admin']);

        $admin = Role::create(['name' => 'admin']);
        $admin->syncPermissions(['create buildings', 'edit buildings', 'delete buildings', 'create floors', 'edit floors', 'delete floors', 'create flats', 'edit flats', 'delete flats', 'create partitions', 'edit partitions', 'delete partitions', 'create cards', 'edit cards', 'delete cards', 'create tenants', 'edit tenants', 'delete tenants', 'create referrers', 'edit referrers', 'delete referrers', 'manage settings', 'create cardreceipts', 'edit cardreceipts', 'delete cardreceipts', 'create invoices', 'edit invoices', 'delete invoices', 'create paybalances', 'edit paybalances', 'delete paybalances', 'edit users', 'view users']);

        $manager = Role::create(['name' => 'manager']);
        $manager->syncPermissions(['create buildings', 'create floors', 'create flats', 'create partitions', 'create cards', 'create tenants', 'create referrers', 'create cardreceipts', 'create invoices', 'create paybalances',]);

        $supervisor = Role::create(['name' => 'supervisor']);
        $supervisor->syncPermissions(['create buildings', 'create floors', 'create flats', 'create partitions', 'create cards', 'create tenants', 'create referrers', 'create cardreceipts', 'create invoices', 'create paybalances',]);

        // Give roles to users
        $mrfrank = User::findOrFail(1);
        $mrfrank->assignRole($super_admin);

        $admin_user = User::findOrFail(2);
        $admin_user->assignRole($admin);

        $manager_user = User::findOrFail(3);
        $manager_user->assignRole($manager);

        $supervisor_user = User::findOrFail(4);
        $supervisor_user->assignRole($supervisor);
    }
}
