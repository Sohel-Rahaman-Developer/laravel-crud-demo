<?php

namespace Tests\Feature;

use App\Livewire\Posts\Index;
use App\Models\Post;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Livewire\Livewire;
use PHPUnit\Framework\Attributes\Test;
use Tests\TestCase;

class PostIndexSearchTest extends TestCase
{
    use RefreshDatabase;

    #[Test]
    public function search_filters_results(): void
    {
        Post::factory()->count(3)->create(['title' => 'Laravel Rocks']);
        Post::factory()->count(2)->create(['title' => 'Other Topic']);

        Livewire::test(Index::class)
            ->set('search', 'Laravel')
            // ->call('render')  // ❌ render public method nahi, hata diya
            ->assertSee('Laravel Rocks')
            ->assertDontSee('Other Topic');
    }

    #[Test]
    public function pagination_shows_only_per_page_records(): void
    {
        // IDs ascending, latest('id') ke liye simplest check:
        foreach (range(1, 6) as $i) {
            Post::factory()->create(['title' => "A{$i}"]);
        }

        Livewire::test(Index::class)
            ->set('perPage', 5)
            // First page me latest 5 (A6..A2) hone chahiye:
            ->assertSee('A6')
            ->assertSee('A5')
            ->assertSee('A4')
            ->assertSee('A3')
            ->assertSee('A2')
            // Purana A1 first page par nahi hona chahiye:
            ->assertDontSee('A1');
    }
}
