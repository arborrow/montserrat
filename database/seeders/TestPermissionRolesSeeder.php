<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class TestPermissionRolesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $permissions = \App\Models\Permission::all();

        foreach ($permissions as $permission) {
            $role = \App\Models\Role::create([
                'name' => 'test-role:'.$permission->name,
                'display_name' => 'test-role:'.$permission->name,
                'description' => 'Test role with permission: '.$permission->name,
            ]);
            $role->givePermissionTo($permission);
        }
        // manually create some roles where more than one permission is required

        $role = \App\Models\Role::create([
            'name' => 'test-role:'.'finance_reconcile_deposit_show',
            'display_name' => 'test-role:'.'finance_reconcile_deposit_show',
            'description' => 'Test role with permissions: '.'finance_reconcile_deposit_show',
        ]);
        $permission = \App\Models\Permission::whereName('show-donation')->first();
        $role->givePermissionTo($permission);
        $permission = \App\Models\Permission::whereName('show-registration')->first();
        $role->givePermissionTo($permission);

        /**
         * PageController retreatantinforeport
         * Permissions: show-contact, show-registration.
         */
        $role = \App\Models\Role::create([
            'name' => 'test-role:'.'retreatantinforeport',
            'display_name' => 'test-role:'.'retreatantinforeport',
            'description' => 'Test role with permissions: '.'retreatantinforeport',
        ]);
        $permission = \App\Models\Permission::whereName('show-contact')->first();
        $role->givePermissionTo($permission);
        $permission = \App\Models\Permission::whereName('show-registration')->first();
        $role->givePermissionTo($permission);

        /**
         * PersonController merge
         * Permissions: update-contact, update-relationship, update-attachment, update-touchpoint, update-donation, update-payment.
         */
        $role = \App\Models\Role::create([
            'name' => 'test-role:'.'merge',
            'display_name' => 'test-role:'.'merge',
            'description' => 'Test role with permissions: '.'merge',
        ]);
        $permission = \App\Models\Permission::whereName('update-contact')->first();
        $role->givePermissionTo($permission);
        $permission = \App\Models\Permission::whereName('update-relationship')->first();
        $role->givePermissionTo($permission);
        $permission = \App\Models\Permission::whereName('update-attachment')->first();
        $role->givePermissionTo($permission);
        $permission = \App\Models\Permission::whereName('update-touchpoint')->first();
        $role->givePermissionTo($permission);
        $permission = \App\Models\Permission::whereName('update-donation')->first();
        $role->givePermissionTo($permission);
        $permission = \App\Models\Permission::whereName('update-payment')->first();
        $role->givePermissionTo($permission);

        /**
         * PermissionController update_roles
         * Permissions: update-permission, update-role.
         */
        $role = \App\Models\Role::create([
            'name' => 'test-role:'.'update_roles',
            'display_name' => 'test-role:'.'update_roles',
            'description' => 'Test role with permissions: '.'update_roles',
        ]);
        $permission = \App\Models\Permission::whereName('update-permission')->first();
        $role->givePermissionTo($permission);
        $permission = \App\Models\Permission::whereName('update-role')->first();
        $role->givePermissionTo($permission);

        /**
         * RelationshipTypeController add
         * Permissions: create-relationship, show-contact.
         */
        $role = \App\Models\Role::create([
            'name' => 'test-role:'.'relationship_type_add',
            'display_name' => 'test-role:'.'relationship_type_add',
            'description' => 'Test role with permissions: '.'relationship_type_add',
        ]);
        $permission = \App\Models\Permission::whereName('create-relationship')->first();
        $role->givePermissionTo($permission);
        $permission = \App\Models\Permission::whereName('show-contact')->first();
        $role->givePermissionTo($permission);
    }
}
