<?php

namespace Tests\Feature;

use App\Models\Anime;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class DashboardTest extends TestCase
{
    use RefreshDatabase;

    public function test_guests_are_redirected_to_the_login_page(): void
    {
        $response = $this->get(route('dashboard'));
        $response->assertRedirect(route('login'));
    }

    public function test_authenticated_users_can_visit_the_dashboard(): void
    {
        $user = User::factory()->create([
            'email_verified_at' => now(),
        ]);
        $this->actingAs($user);

        $response = $this->get(route('dashboard'));
        $response->assertStatus(200);
        $response->assertViewIs('dashboard');
        $response->assertViewHas('animes');
    }

    public function test_guests_cannot_create_an_anime(): void
    {
        $response = $this->post(route('dashboard.animes.store'), [
            'title' => 'Attack on Titan',
            'synopsis' => 'A battle for humanity.',
            'genres' => 'Action, Drama',
        ]);

        $response->assertRedirect(route('login'));
        $this->assertDatabaseCount('animes', 0);
    }

    public function test_verified_users_can_create_an_anime(): void
    {
        $user = User::factory()->create([
            'email_verified_at' => now(),
        ]);
        $this->actingAs($user);

        $response = $this->post(route('dashboard.animes.store'), [
            'title' => 'Naruto',
            'synopsis' => 'A young ninja seeks recognition.',
            'genres' => 'Action, Adventure',
        ]);

        $response->assertRedirect(route('dashboard'));
        $response->assertSessionHas('status');

        $anime = Anime::query()->where('title', 'Naruto')->first();

        $this->assertNotNull($anime);
        $this->assertSame('naruto', $anime->slug);
        $this->assertSame(['Action', 'Adventure'], $anime->genres);
    }

    public function test_slug_is_incremented_when_title_already_exists(): void
    {
        $user = User::factory()->create([
            'email_verified_at' => now(),
        ]);
        $this->actingAs($user);

        Anime::factory()->create([
            'title' => 'Naruto',
            'slug' => 'naruto',
        ]);

        $response = $this->post(route('dashboard.animes.store'), [
            'title' => 'Naruto',
            'synopsis' => 'Another tale from the Hidden Leaf.',
            'genres' => 'Action',
        ]);

        $response->assertRedirect(route('dashboard'));

        $this->assertDatabaseHas('animes', [
            'title' => 'Naruto',
            'slug' => 'naruto-2',
        ]);
    }
}
