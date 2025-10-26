<?php

namespace Tests\Feature;

use App\Livewire\Posts\Edit;
use App\Livewire\Posts\Index;
use App\Models\Post;
use Illuminate\Foundation\Testing\RefreshDatabase;
use PHPUnit\Framework\Attributes\Test;
use Tests\TestCase;

class HttpPagesTest extends TestCase
{
    use RefreshDatabase;

    #[Test]
    public function home_redirects_to_posts_or_renders_ok(): void
    {
        // Agar aapka "/" homepage hai (hello ya posts), bas 200 ok expect.
        // Agar "/" redirect karta hai "/posts" par, to 302 + follow redirect ok.
        $res = $this->get('/');
        $res->assertStatus(in_array($res->getStatusCode(), [200, 302]) ? $res->getStatusCode() : 200);

        if ($res->getStatusCode() === 302) {
            $this->followRedirects($res)->assertOk();
        }
    }

    #[Test]
    public function posts_index_page_loads_and_contains_livewire_component(): void
    {
        $this->get('/posts')
            ->assertOk()
            ->assertSee('Posts')
            // Response macro from Livewire: page pe component mount hua?
            ->assertSeeLivewire(Index::class);
    }

    #[Test]
    public function edit_page_for_existing_post_loads_and_contains_livewire_component(): void
    {
        /** @var \App\Models\Post $post */
        $post = Post::factory()->create(['title' => 'Edit Me']);

        $this->get("/posts/{$post->id}/edit")
            ->assertOk()
            ->assertSee('Edit')
            ->assertSee('Edit Me')
            ->assertSeeLivewire(Edit::class);
    }

    #[Test]
    public function edit_page_for_missing_post_returns_404(): void
    {
        $this->get('/posts/999999/edit')->assertNotFound();
    }
}
