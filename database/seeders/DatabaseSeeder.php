<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;

use App\Models\Applicant;
use App\Models\User;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        try {
            $this->call([
                PermissionSeeder::class,
                RoleSeeder::class,
                UserSeeder::class,
                ApplicantSeeder::class,
                ApplicantWithoutOwnerSeeder::class
            ]);
        } catch (\Throwable $th) {
            throw $th;
        }

    }
}
