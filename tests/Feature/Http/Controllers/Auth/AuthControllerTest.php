<?php

namespace Tests\Feature\Http\Controllers\Auth;

use Illuminate\Foundation\Auth\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use RuntimeException;
use Tests\TestCase;

class AuthControllerTest extends TestCase
{
    use RefreshDatabase;

    /**
     * A basic feature test example.
     *
     * @return void
     */
    public function test_a_user_can_login_with_username_and_password()
    {
        $user = $this->createUser(['username' => 'user.manager']);
        $this->actingAs($user, 'api');

        $response = $this->postJson(route('login'),[
            'username' => 'user.manager',
            'password' => 'password'
        ]);

        $this->assertEquals(200, $response->status());

        $content = json_decode($response->getContent());

        if (!isset($content->data->token)) {
            throw new RuntimeException('Token missing in response');
        }
        $this->token = $content->data->token;
        return $content->data->token;
    }

    public function test_if_user_username_is_not_available_then_it_return_error()
    {
        $this->postJson(route('login'),[
            'username' => 'Sarthak@bitfumes.com',
            'password' => 'password'
        ])
        ->assertUnauthorized();
    }
}

