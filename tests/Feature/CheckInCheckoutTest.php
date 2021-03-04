<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use App\Book;
use App\User;
use Crypt;

class CheckInCheckoutTest extends TestCase
{
    use WithFaker;

    public function testUserAction()
    {
        $book = factory(Book::class)->create();
        $encBookId = Crypt::encrypt($book->id);
        $payload = [
            'book_id'   => $encBookId,
            'action'    => 'CHECKOUT'    
        ];
        $this->json('post', '/api/user/actions', $payload, $this->getHeaders())
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
                    'errors' => [
                        'book_id' => ['The book id field is required.'],
                        'action' => ['The action field is required.'],
                    ]
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
