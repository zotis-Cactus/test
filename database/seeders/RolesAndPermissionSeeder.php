<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;

class RolesAndPermissionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // Reset cached roles and permissions
        app()[\Spatie\Permission\PermissionRegistrar::class]->forgetCachedPermissions();

        Permission::create(['name' => 'edit permissions']);
        Permission::create(['name' => 'crud roles']);
        Permission::create(['name' => 'view logs']);

        Permission::create(['name' => 'edit users']);
        Permission::create(['name' => 'delete users']);
        Permission::create(['name' => 'view users']);
        Permission::create(['name' => 'create users']);

        $role_admin = Role::create(['name' => 'Διαχειριστής']);
        $role_admin->syncPermissions(Permission::all());
        $user = \App\Models\User::factory()->create([
            'name' => 'Admin',
            'email' => 'admin@cactusweb.gr',
        ]);
        $user->assignRole($role_admin);
        $user->password = bcrypt('123456');
        $user->save();

        $role_user = Role::create(['name' => 'Υπάλληλος']);
        $user = \App\Models\User::factory()->create([
            'name' => 'Υπάλληλος',
            'email' => 'employee@cactusweb.gr',
        ]);
        $user->assignRole($role_user);
        $user->password = bcrypt('123456');
        $user->save();


        $role = Role::create(['name' => 'super-admin']);
        $role->syncPermissions(Permission::all());
        $user = \App\Models\User::factory()->create([
            'name' => 'Cactus',
            'email' => 'dimitris@cactusweb.gr',
        ]);
        $user->assignRole($role);
        $user->password = bcrypt('1425lx36');
        $user->save();
    }
}
