<?php

namespace Tests\Feature\Auth;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class LoginTest extends TestCase
{
    use RefreshDatabase;

    public function test_A_user_can_login()
    {
        $user = User::factory()->create();

        $response = $this->postJson(route('user.login'),[
            'email'=>$user->email,
            'password'=>'password'
        ])
        ->assertOk();

        $this->assertArrayHasKey('token',$response->json());
    }

    public function test_if_user_email_is_available_then_it_returns_error()
    {
        $this->postJson(route('user.login'),[
            'email'=>'awais@gmail.com',
            'password'=>'password'
        ])
        ->assertUnauthorized();
    }

    public function test_if_user_password_is_correct_then_it_returns_error()
    {
        $user = User::factory()->create();

        $this->postJson(route('user.login'),[
            'email'=>$user->email,
            'password'=>'wrong_password'
        ])
        ->assertUnauthorized();
    }


}
