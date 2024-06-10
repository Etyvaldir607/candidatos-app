<?php

namespace Tests;

use App\Models\Applicant;
use App\Models\User;
use Illuminate\Foundation\Testing\TestCase as BaseTestCase;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

abstract class TestCase extends BaseTestCase
{
    use CreatesApplication;

    /**
     * @var string
     */
    public $token = '';

    public function setUp(): void
    {
        parent::setUp();
        $this->withoutExceptionHandling();

        //now de-register all the roles and permissions by clearing the permission cache
        $this->app->make(\Spatie\Permission\PermissionRegistrar::class)->forgetCachedPermissions();

    }

    public function createRole($args = [])
    {
        return Role::factory()->create($args);
    }

    public function createUser($args = [])
    {
        return User::factory()->create($args);
    }

    public function createApplicant($args = [])
    {
        return Applicant::factory()->create($args);
    }

    public function createRoleAsManager($args = [])
    {
        $role_created = $this->createRole(['name' => 'manager']);
        $role_created->givePermissionTo(Permission::all());

        return $role_created;
    }

    public function createUserAsAgent($args = [])
    {
        return User::factory()->create($args);
    }


}
