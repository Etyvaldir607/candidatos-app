<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class RoleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $roles = [
            'manager',
            'agent',
        ];

        $progressBar = $this->command->getOutput()->createProgressBar(count($roles));

        foreach ($roles as $role) {
            $role_created = Role::create(['name' => $role]);
            switch ($role_created->name) {
                case 'manager':
                    $role_created->givePermissionTo(Permission::all());
                    break;

                case 'agent':
                    $role_created->givePermissionTo(['owner applicant']);
                    break;

                default:
                    # code...
                    break;
            }

            $progressBar->advance();
        }

        $progressBar->finish();
    }
}
