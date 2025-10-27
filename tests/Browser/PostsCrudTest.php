<?php

namespace Tests\Browser;

use App\Models\Post;
use Laravel\Dusk\Browser;
use Tests\DuskTestCase;

class PostsCrudTest extends DuskTestCase
{
    /** @test */
    public function user_can_create_a_post_via_ui(): void
    {
        $this->browse(function (Browser $browser) {
            $browser->visitRoute('posts.index')
                ->waitFor('@title', 10)
                ->type('@title', 'New From Dusk')
                ->type('@content', 'Body from Dusk')
                ->click('@add-post')
                ->waitForText('New From Dusk', 5)
                ->assertSee('New From Dusk');
        });
    }

    /** @test */
    public function user_can_search_and_paginate(): void
    {
        Post::factory()->create(['title' => 'A1']);
        Post::factory()->create(['title' => 'B2']);
        Post::factory()->count(10)->create(['title' => 'Item']);

        $this->browse(function (Browser $browser) {
            $browser->visitRoute('posts.index')
                ->waitFor('@perPage', 10)
                ->select('@perPage', '5')
                ->waitFor('@search', 5)
                ->type('@search', 'A1')
                ->pause(1000) // debounce + Livewire render + DOM settle
                ->assertSee('A1')
                ->assertDontSee('B2');
        });
    }

    /** @test */
    public function user_can_edit_and_delete_a_post(): void
    {
        $post = Post::factory()->create(['title' => 'Old']);

        $this->browse(function (Browser $browser) use ($post) {
            // Edit
            $browser->visitRoute('posts.index')
                ->waitFor("@edit-{$post->id}", 10)
                ->click("@edit-{$post->id}")
                ->waitFor('@title', 10)
                ->clear('@title')->type('@title', 'Updated by Dusk')
                ->click('@save-post');

            // Verify update on index
            $browser->visitRoute('posts.index')
                ->waitForText('Updated by Dusk', 5)
                ->assertSee('Updated by Dusk')

                // Delete (handle confirm dialog)
                ->click("@edit-{$post->id}")
                ->waitFor('@delete-post', 10)
                ->click('@delete-post');

            // Accept native confirm (works across Dusk versions)
            try {
                // Newer Dusk
                $browser->waitForDialog(5)->acceptDialog();
            } catch (\Throwable $e) {
                // Fallback to raw WebDriver if waitForDialog/acceptDialog not available
                $browser->pause(200);
                $browser->driver->switchTo()->alert()->accept();
            }

            // Back to index and assert record removed
            $browser->waitForLocation('/posts', 10)
                ->assertDontSee('Updated by Dusk');
        });
    }
}
