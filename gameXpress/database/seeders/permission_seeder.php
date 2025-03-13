<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;
use Spatie\Permission\PermissionRegistrar;

class permission_seeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        app(PermissionRegistrar::class)->forgetCachedPermissions();

        // permissions..
        $permissions = [
            'view_dashboard',
            'view_products', 'create_products', 'edit_products', 'delete_products',
            'view_categories', 'create_categories', 'edit_categories', 'delete_categories',
            'view_users', 'create_users', 'edit_users', 'delete_users',
        ];

        foreach ($permissions as $permission)
        {
            Permission::create(['name' => $permission]);
        }

        // roles..
        $super_admin = Role::create(['name' => 'super_admin']);
        $super_admin->givePermissionTo($permissions);

        $product_manager = Role::create(['name' => 'product_manager']);
        $product_manager->givePermissionTo(['view_products', 'create_products', 'edit_products', 'delete_products']);

        $user_manager = Role::create(['name' => 'user_manager']);
        $user_manager->givePermissionTo(['view_users', 'create_users', 'edit_users', 'delete_users']);

        // demo user
        // $admin = User::factory()->create([
        //     'name' => 'Admin',
        //     'email' => 'admin@gmail.com',
        //     'password' => bcrypt('password')
        // ]);
        // $admin->assignRole('super_admin');
    }
}
