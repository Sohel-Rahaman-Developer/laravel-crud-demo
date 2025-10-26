<?php

namespace App\Livewire\Posts;

use App\Models\Post;
use Livewire\Component;
use Livewire\WithPagination;

class Index extends Component
{
    use WithPagination;

    public string $title = '';
    public string $content = '';
    public string $search = '';
    public int $perPage = 5;

    protected $rules = [
        'title'   => ['required', 'string', 'max:255'],
        'content' => ['nullable', 'string'],
    ];

    protected $messages = [
        'title.required' => 'Title is required.',
        'title.max'      => 'Title must be at most 255 characters.',
    ];

    public function updatedSearch(): void
    {
        $this->resetPage();
    }

    public function save(): void
    {
        $validated = $this->validate();

        // Post::create($validated);
        Post::query()->create($validated);

        $this->reset(['title', 'content']);

        // toast (browser event)
        $this->dispatch('notify', message: 'Post created successfully.', variant: 'success');

        // Re-render with first page to show fresh data if needed
        $this->resetPage();
    }

public function render()
    {
        $keyword = trim($this->search ?? ''); // <-- IMPORTANT

        $posts = Post::query()
            ->when($keyword !== '', function ($q) use ($keyword) {
                $q->where(function ($q) use ($keyword) {
                    $q->where('title', 'like', "%{$keyword}%")
                      ->orWhere('content', 'like', "%{$keyword}%");
                });
            })
            ->latest('id')
            ->paginate($this->perPage);

        return view('livewire.posts.index', [
            'posts' => $posts,
        ])->layout('components.layouts.app', ['title' => 'Posts']);
    }
}
