<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\PermissionRegistrar;

class PermissionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        app()[PermissionRegistrar::class]->forgetCachedPermissions();

        $permissions = [
            // aplicants
            'index applicant',
            'store applicant',
            'show applicant',

            // applicants - with owner
            'owner applicant'
        ];

        $progressBar = $this->command->getOutput()->createProgressBar(count($permissions));

        foreach ($permissions as $permission) {
            Permission::create(['name' => $permission, 'guard_name' => 'api']);
            $progressBar->advance();
        }

        $progressBar->finish();
    }
}
