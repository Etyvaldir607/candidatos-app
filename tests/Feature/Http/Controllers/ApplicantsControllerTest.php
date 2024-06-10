<?php

namespace Tests\Feature\Http\Controllers\Auth;

use App\Models\Applicant;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class ApplicantsControllerTest extends TestCase
{
    /**
     * get index.
     *
     * @return void
     */
    public function test_index_as_manager()
    {
        $manager = $this->createUser()->assignRole('manager');
        $token = $manager->createToken()->accessToken;
        $response = $this->actingAs($manager)->getJson(route('applicants.index'), ['Authorization' => "Bearer $token"]);
        $response->assertStatus(200);
    }

    /**
     * get index only with owner assigned.
     *
     * @return void
     */
    public function test_index_as_agent()
    {
        $agent = $this->createUser()->assignRole('agent');
        $token = $agent->createToken()->accessToken;
        $response = $this->actingAs($agent)->getJson(route('applicants.index'), ['Authorization' => "Bearer $token"]);
        $response->assertStatus(200);
    }

    /**
     * get index.
     *
     * @return void
     */
    public function test_store_as_manager()
    {
        $manager = $this->createUser()->assignRole('manager');
        $token = $manager->createToken()->accessToken;

        $response = $this->actingAs($manager)->postJson(route('applicants.store'), [
            'name'      => 'test',
            'source'    => 'test source',
            'owner'     => '2'
        ], ['Authorization' => "Bearer $token"]);
        $response->assertStatus(200);
    }

    /**
     * get index.
     *
     * @return void
     */
    public function test_show_as_manager()
    {
        $manager = $this->createUser()->assignRole('manager');
        $token = $manager->createToken()->accessToken;
        $applicant = $this->createApplicant();
        $response = $this->actingAs($manager)->getJson(route('applicants.show', ['id' => $applicant->id]), ['Authorization' => "Bearer $token"]);
        $response->assertStatus(200);
    }
}
