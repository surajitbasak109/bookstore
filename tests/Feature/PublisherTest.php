<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Testing\Fluent\AssertableJson;
use Tests\TestCase;
use App\Models\Publisher;

class PublisherTest extends TestCase
{
    /**
     * A basic feature test example.
     *
     * @return void
     */
    public function test_index_authentication()
    {
        $this->assertAuthenticationRequired('/publishers');
        $this->assertAuthenticationRequired('/publishers/datatables');
        $this->assertAuthenticationRequired('/publishers/{publisher}');
    }

    public function test_index_view()
    {
        $user = User::first();
        $response = $this->actingAs($user)->get('/publishers');

        $response->assertStatus(200);
        $response->assertSee('container');
    }

    public function test_authenticated_user_can_create_new_publisher()
    {
        $user = User::first();
        $this->actingAs($user)->get('/publishers')
            ->assertStatus(200);

        $name = fake()->name();

        $this->post('/publishers', [
            'name' => $name,
        ])->assertJson(fn (AssertableJson $json) => $json->where('publisher.name', $name)->etc());
    }

    public function test_it_checks_for_invalid_post_data()
    {
        $user = User::first();
        $this->actingAs($user);

        $this->postJson('/publishers', [])->assertJsonStructure(['message', 'errors' => ['name']]);
    }

    public function test_authenticated_user_can_edit_an_existing_publisher()
    {
        $publisher = $this->createPublisher();

        $updatedAuthorName = "U. " . $publisher->name;

        $this->put(
            "/publishers/{$publisher->id}",
            array_merge($publisher->toArray(), ['name' => $updatedAuthorName,])
        )
            ->assertStatus(200)
            ->assertJson(fn (AssertableJson $json) => $json->where('publisher.name', $updatedAuthorName)->etc());
    }

    public function test_authenticated_user_can_delete_existing_publisher()
    {
        $publisher = $this->createPublisher();

        $this->delete("/publishers/{$publisher->id}")
            ->assertStatus(200);
    }

    private function createPublisher($authenticated = true)
    {
        $book = Publisher::create(['name' => fake()->name()]);

        if ($authenticated) {
            $this->actingAs(User::first());
        }

        return $book;
    }
}
