<?php

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;
use Spatie\Permission\PermissionRegistrar;
use Illuminate\Support\Facades\Hash;
use Illuminate\Foundation\Auth\User;

class PermissionsSeeder extends Seeder
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

        // create permissions
        Permission::create(['name' => 'view users']);
        Permission::create(['name' => 'edit users']);
        Permission::create(['name' => 'approve users']);

        // create roles and assign existing permissions
        $admin_role = Role::create(['name' => 'admin']);
        $admin_role->givePermissionTo('view users');
        $admin_role->givePermissionTo('edit users');
        $admin_role->givePermissionTo('approve users');

        $user = factory(App\User::class)->create([
            'name' => 'Admin',
            'email' => 'admin@admin.com',
            'password' => Hash::make('Qwert211'),
        ]);
        $user->assignRole($admin_role);
    }
}
