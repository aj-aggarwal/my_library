<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class RegisterTest extends TestCase
{
    use WithFaker;

    public function testRegisterSuccessfully()
    {
        $payload = [
            'name' => $this->faker->name,
            'email' => $this->faker->email,
            'password' => 'Test1234',
            'password_confirmation' => 'Test1234',
            'date_of_birth' => $this->faker->dateTimeThisCentury->format('Y-m-d'),
        ];

        $this->json('post', '/api/register', $payload)
            ->assertStatus(200)
            ->assertJson([
                'message' => trans('messages.registered_successfully'),
            ]);
            
    }

    public function testRequiredFields()
    {
        $this->json('post', '/api/register')
            ->assertStatus(422)
            ->assertJson([
                    'message' => 'The given data was invalid.',
                    'errors' => [
                        'name' => ['The name field is required.'],
                        'email' => ['The email field is required.'],
                        'password' => ['The password field is required.'],
                        'date_of_birth' => ['The date of birth field is required.']
                    ]
            ]);
    }

    public function testPasswordConfirmation()
    {
        $payload = [
            'name' => $this->faker->name,
            'email' => $this->faker->email,
            'password' => 'T12345678',
            'password_confirmation' => 'T1234567890'
        ];

        $this->json('post', '/api/register', $payload)
            ->assertStatus(422)
            ->assertJson([
                    'message' => 'The given data was invalid.',
                    'errors' => [
                        'password' => ['The password confirmation does not match.'],
                    ]
            ]);
    }

    public function testPasswordFormat()
    {
        $payload = [
            'name' => $this->faker->name,
            'email' => $this->faker->email,
            'password' => '12345',
            'password_confirmation' => '12345'
        ];

        $this->json('post', '/api/register', $payload)
            ->assertStatus(422)
            ->assertJson([
                'message' => 'The given data was invalid.',
                'errors' => [
                    'password' => [
                        "The password must be at least 8 characters.",
                        trans('messages.password_format'),
                    ],
                ],
            ]);
    }
}
