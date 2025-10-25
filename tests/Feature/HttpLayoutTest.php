<?php

namespace Tests\Feature;

use App\Models\Post;
use Illuminate\Foundation\Testing\RefreshDatabase;
use PHPUnit\Framework\Attributes\Test;
use Tests\TestCase;

class HttpLayoutTest extends TestCase
{
    use RefreshDatabase;

    #[Test]
    public function posts_index_has_expected_chrome(): void
    {
        $this->get('/posts')
            ->assertOk()
            ->assertSee('<title>', false)        // has <title> tag
            ->assertSee('Bootstrap', false)      // CDN loaded (word occurs in link tag)
            ->assertSee('Search title/content...'); // search input placeholder text
    }

    #[Test]
    public function posts_index_lists_records_in_table_rows(): void
    {
        $a = Post::factory()->create(['title' => 'Row A']);
        $b = Post::factory()->create(['title' => 'Row B']);

        $this->get('/posts')
            ->assertOk()
            // th headers
            ->assertSee('<th>Title</th>', false)
            ->assertSee('Row A')
            ->assertSee('Row B');
    }
}
