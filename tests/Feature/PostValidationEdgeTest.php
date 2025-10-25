<?php

namespace Tests\Feature;

use App\Livewire\Posts\Index;
use App\Models\Post;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Livewire\Livewire;
use PHPUnit\Framework\Attributes\Test;
use Tests\TestCase;

class PostValidationEdgeTest extends TestCase
{
    use RefreshDatabase;

    #[Test]
    public function title_cannot_exceed_255_chars(): void
    {
        $tooLong = str_repeat('a', 256);

        Livewire::test(Index::class)
            ->set('title', $tooLong)
            ->set('content', 'ok')
            ->call('save')
            ->assertHasErrors(['title' => 'max']);
    }

    #[Test]
    public function content_is_optional(): void
    {
        Livewire::test(Index::class)
            ->set('title', 'Only Title')
            ->set('content', '')
            ->call('save')
            ->assertHasNoErrors();

        $this->assertDatabaseHas('posts', ['title' => 'Only Title']);
    }

#[Test]
public function search_is_case_insensitive_and_trims_whitespace(): void
{
    Post::factory()->create(['title' => 'Laravel Tips']);
    Post::factory()->create(['title' => 'Other']);

    Livewire::test(\App\Livewire\Posts\Index::class)
        ->set('search', '   laravel   ')
        ->assertSee('Laravel Tips')
        ->assertDontSee('Other');
}

}
