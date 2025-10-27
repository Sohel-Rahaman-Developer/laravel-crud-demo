<?php

namespace App\Livewire\Posts;

use App\Models\Post;
use Livewire\Component;

class Edit extends Component
{
    public Post $post;
    public string $title = '';
    public string $content = '';

    protected function rules(): array
    {
        return [
            'title'   => ['required', 'string', 'max:255'],
            'content' => ['nullable', 'string'],
        ];
    }

    public function mount(Post $post): void
    {
        $this->post    = $post;
        $this->title   = (string) $post->title;
        $this->content = (string) ($post->content ?? '');
    }

    public function update(): void
    {
        $validated = $this->validate();
        $this->post->update($validated);

        $this->dispatch('notify', message: 'Post updated successfully.', variant: 'success');

        // ✅ Dusk expects redirect back to index after Save
        $this->redirectRoute('posts.index', navigate: true);
    }

    public function delete(): void
    {
        $this->post->delete();

        $this->dispatch('notify', message: 'Post deleted.', variant: 'danger');
        $this->redirectRoute('posts.index', navigate: true);
    }

    public function render()
    {
        return view('livewire.posts.edit')
            ->title('Edit Post')
            ->layout('components.layouts.app');
    }
}
