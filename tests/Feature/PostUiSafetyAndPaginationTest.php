<?php

namespace Tests\Feature;

use App\Livewire\Posts\Index;
use App\Models\Post;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Livewire\Livewire;
use PHPUnit\Framework\Attributes\Test;
use Tests\TestCase;

class PostUiSafetyAndPaginationTest extends TestCase
{
    use RefreshDatabase;

    #[Test]
    public function content_is_escaped_in_list_to_prevent_xss(): void
    {
        Post::factory()->create([
            'title' => 'XSS',
            'content' => '<script>alert("x")</script>',
        ]);

        Livewire::test(Index::class)
            // ensure raw script tag is NOT printed unescaped
            ->assertDontSee('<script>alert("x")</script>', false)
            ->assertSee('XSS'); // row shows
    }

   #[Test]
public function pagination_respects_per_page_and_handles_out_of_range_pages(): void
{
    foreach (range(1, 6) as $i) {
        Post::factory()->create(['title' => "A{$i}"]);
    }

    // Page 1 (perPage=5) => latest 5: A6..A2; A1 not visible
    Livewire::test(Index::class)
        ->set('perPage', 5)
        ->assertSee('A6')
        ->assertSee('A5')
        ->assertSee('A4')
        ->assertSee('A3')
        ->assertSee('A2')
        ->assertDontSee('A1');

    // Out-of-range page: paginator returns empty; UI shows empty state
    $lw = Livewire::test(Index::class)
        ->set('perPage', 5)
        ->call('gotoPage', 999, 'page')
        ->assertSee('No posts found.')
        ->assertDontSee('A6')
        ->assertDontSee('A2');

    // Valid last page: explicitly go to page 2 => should show oldest item A1
    $lw->call('gotoPage', 2, 'page')
        ->assertSee('A1')
        ->assertDontSee('A6');
}

}
