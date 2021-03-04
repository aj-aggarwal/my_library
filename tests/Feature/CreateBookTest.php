<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use App\Book;
use App\User;

class CreateBookTest extends TestCase
{
    /**
     * A basic feature test example.
     *
     * @return void
     */
    public function testBookCreatedSuccessfully()
    {
        $book = factory(Book::class)->make();
        
        $payload = [
            'title' => $book->title,
            'isbn' => $book->isbn,
            'published_at' => $book->published_at,
        ];

        $this->json('post', '/api/books/create', $payload, $this->getHeaders())
            ->assertStatus(200)
            ->assertJsonStructure([
                'message'
            ]);
    }

    public function testRequiredFields()
    {
        $this->json('POST', '/api/user/actions', [], $this->getHeaders())
            ->assertStatus(422)
            ->assertJson([
                'message' => 'The given data was invalid.',
            ]);
    }

    public function testInvalidIsbn()
    {
        $book = factory(Book::class)->make();

        $payload = [
            'title' => $book->title,
            'isbn' => '1234567890',
            'published_at' => $book->published_at,
        ];

        $this->json('post', '/api/books/create', $payload, $this->getHeaders())
            ->assertStatus(422)
            ->assertJson([
                'message' => trans('messages.invalid_isbn'),
            ]);
    }

    /***** Private Section*****/

    private function getHeaders()
    {
        $user = factory(User::class)->create();
        $token = $user->createToken(config('constants.personal_grant_client'))->accessToken;
        $headers = ['Authorization' => "Bearer $token"];

        return $headers;
    }
}
