<?php

namespace Tests\Feature;

use App\Models\Author;
use App\Models\User;
use Illuminate\Testing\Fluent\AssertableJson;
use Tests\TestCase;

class AuthorTest extends TestCase
{
    /**
     * A basic feature test example.
     *
     * @return void
     */
    public function test_index_authentication()
    {
        $this->assertAuthenticationRequired('/authors');
        $this->assertAuthenticationRequired('/authors/datatables');
        $this->assertAuthenticationRequired('/authors/{author}');
    }

    public function test_index_view()
    {
        $user = User::first();
        $response = $this->actingAs($user)->get('/authors');

        $response->assertStatus(200);
        $response->assertSee('container');
    }

    public function test_authenticated_user_can_create_new_author()
    {
        $user = User::first();
        $this->actingAs($user)->get('/authors')
            ->assertStatus(200);

        $name = fake()->name();

        $this->post('/authors', [
            'name' => $name,
        ])->assertJson(fn (AssertableJson $json) => $json->where('author.name', $name)->etc());
    }

    public function test_it_checks_for_invalid_post_data()
    {
        $user = User::first();
        $this->actingAs($user);

        $this->postJson('/authors', [])->assertJsonStructure(['message', 'errors' => ['name']]);
    }

    public function test_authenticated_user_can_edit_an_existing_author()
    {
        $author = $this->createAuthor();

        $updatedAuthorName = "U. " . $author->name;

        $this->put(
            "/authors/{$author->id}",
            array_merge($author->toArray(), ['name' => $updatedAuthorName,])
        )
            ->assertStatus(200)
            ->assertJson(fn (AssertableJson $json) => $json->where('author.name', $updatedAuthorName)->etc());
    }

    public function test_authenticated_user_can_delete_existing_author()
    {
        $author = $this->createAuthor();

        $this->delete("/authors/{$author->id}")
            ->assertStatus(200);
    }

    private function createAuthor($authenticated = true)
    {
        $book = Author::create(['name' => fake()->name()]);

        if ($authenticated) {
            $this->actingAs(User::first());
        }

        return $book;
    }
}
