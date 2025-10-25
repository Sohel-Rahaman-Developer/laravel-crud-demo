<?php

namespace Tests\Feature;

use App\Livewire\Posts\Edit;
use App\Models\Post;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Livewire\Livewire;
use PHPUnit\Framework\Attributes\Test;
use Tests\TestCase;

class PostEditTest extends TestCase
{
    use RefreshDatabase;

    #[Test]
    public function update_requires_title(): void
    {
        $post = Post::factory()->create(['title' => 'Keep']);

        Livewire::test(Edit::class, ['post' => $post]) // <-- pass MODEL, not ID
            ->set('title', '') // invalid
            ->call('update')
            ->assertHasErrors(['title' => 'required']);
    }

    #[Test]
    public function can_update_post(): void
    {
        $post = Post::factory()->create(['title' => 'Old Title', 'content' => 'Old']);

        Livewire::test(Edit::class, ['post' => $post]) // <-- pass MODEL
            ->set('title', 'Updated Title')
            ->set('content', 'Updated Body')
            ->call('update')
            ->assertHasNoErrors()
            ->assertDispatched('notify');

        $this->assertDatabaseHas('posts', [
            'id' => $post->id,
            'title' => 'Updated Title',
            'content' => 'Updated Body',
        ]);
    }

    #[Test]
    public function can_delete_post_and_redirects_to_index(): void
    {
        $post = Post::factory()->create();

        Livewire::test(Edit::class, ['post' => $post]) // <-- pass MODEL
            ->call('delete')
            ->assertDispatched('notify')
            ->assertRedirect(route('posts.index'));

        $this->assertDatabaseMissing('posts', ['id' => $post->id]);
    }
}
