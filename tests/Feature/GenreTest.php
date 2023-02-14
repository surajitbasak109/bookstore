<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Testing\Fluent\AssertableJson;
use Tests\TestCase;
use App\Models\Genre;

class GenreTest extends TestCase
{
    /**
     * A basic feature test example.
     *
     * @return void
     */
    public function test_index_authentication()
    {
        $this->assertAuthenticationRequired('/genres');
        $this->assertAuthenticationRequired('/genres/datatables');
        $this->assertAuthenticationRequired('/genres/{genre}');
    }

    public function test_index_view()
    {
        $user = User::first();
        $response = $this->actingAs($user)->get('/genres');

        $response->assertStatus(200);
        $response->assertSee('container');
    }

    public function test_authenticated_user_can_create_new_genre()
    {
        $user = User::first();
        $this->actingAs($user)->get('/genres')
            ->assertStatus(200);

        $name = fake()->name();

        $this->post('/genres', [
            'name' => $name,
        ])->assertJson(fn (AssertableJson $json) => $json->where('genre.name', $name)->etc());
    }

    public function test_it_checks_for_invalid_post_data()
    {
        $user = User::first();
        $this->actingAs($user);

        $this->postJson('/genres', [])->assertJsonStructure(['message', 'errors' => ['name']]);
    }

    public function test_authenticated_user_can_edit_an_existing_genre()
    {
        $genre = $this->createGenre();

        $updatedAuthorName = "U. " . $genre->name;

        $this->put(
            "/genres/{$genre->id}",
            array_merge($genre->toArray(), ['name' => $updatedAuthorName,])
        )
            ->assertStatus(200)
            ->assertJson(fn (AssertableJson $json) => $json->where('genre.name', $updatedAuthorName)->etc());
    }

    public function test_authenticated_user_can_delete_existing_genre()
    {
        $genre = $this->createGenre();

        $this->delete("/genres/{$genre->id}")
            ->assertStatus(200);
    }

    private function createGenre($authenticated = true)
    {
        $book = Genre::create(['name' => fake()->name()]);

        if ($authenticated) {
            $this->actingAs(User::first());
        }

        return $book;
    }
}
