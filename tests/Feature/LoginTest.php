<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use App\User;
use Crypt;
use Illuminate\Support\Facades\Hash;

class LoginTest extends TestCase
{
    use WithFaker;

    public function testRequiredFields()
    {
        $this->json('POST', 'api/login')
            ->assertStatus(422)
            ->assertJson([
                'message' => 'The given data was invalid.',
                'errors' => [
                    'email' => ['The email field is required.'],
                    'password' => ['The password field is required.'],
                ]
            ]);
    }

    public function testInvalidCredentials()
    {
        $payload = ['email' => $this->faker->email, 'password' => 'Test12'];

        $this->json('POST', 'api/login', $payload)
            ->assertStatus(422)
            ->assertJson([
                "message" => trans('messages.invalid_credentials'),
            ]);
    }
    
    public function testLoginsSuccessfully()
    {
        $email = $this->faker->email;
        $userEmail = factory(User::class)->create()->email;

        $payload = ['email' => $userEmail, 'password' => 'Test1234'];

        $this->json('POST', 'api/login', $payload)
            ->assertStatus(200)
            ->assertJsonStructure([
                'token'
            ]);
    }
}
