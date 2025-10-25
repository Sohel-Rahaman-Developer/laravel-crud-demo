<?php

namespace Tests\Feature;

use App\Livewire\Posts\Index;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Livewire\Livewire;
use PHPUnit\Framework\Attributes\Test;
use Tests\TestCase;

class PostCreateTest extends TestCase
{
    use RefreshDatabase;

    #[Test]
    public function cannot_create_without_title(): void
    {
        Livewire::test(Index::class)
            ->set('title', '')            // title missing
            ->set('content', 'Body text') // optional
            ->call('save')
            ->assertHasErrors(['title' => 'required']); // validation rule hit
    }

    #[Test]
    public function can_create_with_valid_data(): void
    {
        Livewire::test(Index::class)
            ->set('title', 'New Post')
            ->set('content', 'Some content')
            ->call('save')
            ->assertHasNoErrors()
            ->assertDispatched('notify'); // toast event from component

        $this->assertDatabaseHas('posts', [
            'title' => 'New Post',
            // content optional; title enough to assert
        ]);
    }
}
