<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;
use PHPUnit\Framework\Attributes\Test;

class PostDbTest extends TestCase
{
    use RefreshDatabase; // <-- yeh har test ke start me migrations chalata hai

    #[Test]
    public function posts_page_loads_even_with_empty_table(): void
    {
        // Table exists because migrations ran; no records yet, but page should still load.
        $this->get('/posts')->assertOk();
    }
}
