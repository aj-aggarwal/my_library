<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use App\User;

class LogoutTest extends TestCase
{
    use WithFaker;

    public function testLoggedOut()
    {
        $user = factory(User::class)->create();
        $token = $user->createToken('Laravel Password Grant Client')->accessToken;
        $headers = ['Authorization' => "Bearer $token"];
        
        $this->json('post', '/api/logout', [], $headers)->assertStatus(200);
    }

    public function testUserWithNullToken()
    {
        $user = factory(User::class)->create();
        $token = $user->createToken('Laravel Password Grant Client')->accessToken;
        $headers = ['Authorization' => "Bearer $token"];
        $user->tokens->first()->revoke();

        $this->json('get', '/api/books/list', [], $headers)->assertStatus(401);
    }
}
