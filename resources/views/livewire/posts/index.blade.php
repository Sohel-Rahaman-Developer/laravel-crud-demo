<div class="container py-4">
    <div class="row justify-content-center">
        <div class="col-lg-10">

            <div class="d-flex align-items-center justify-content-between mb-3">
                <h1 class="h4 m-0">Posts</h1>

                <div class="d-flex gap-2">
                    <input
                        type="text"
                        class="form-control"
                        placeholder="Search title/content..."
                        wire:model.live.debounce.300ms="search"
                        style="min-width: 260px;"
                    />
                    <select class="form-select" wire:model.live="perPage" style="width: 110px;">
                        <option value="5">5 / page</option>
                        <option value="10">10 / page</option>
                        <option value="15">15 / page</option>
                    </select>
                </div>
            </div>

            {{-- Create Form --}}
            <div class="card shadow-sm mb-4">
                <div class="card-body">
                    <h2 class="h5 mb-3">Create Post</h2>

                    <form wire:submit.prevent="save" class="row g-3">
                        <div class="col-12">
                            <label class="form-label">Title <span class="text-danger">*</span></label>
                            <input type="text" class="form-control" wire:model.defer="title" placeholder="Post title" />
                            @error('title') <div class="text-danger small mt-1">{{ $message }}</div> @enderror
                        </div>

                        <div class="col-12">
                            <label class="form-label">Content</label>
                            <textarea class="form-control" rows="3" wire:model.defer="content" placeholder="Optional description..."></textarea>
                            @error('content') <div class="text-danger small mt-1">{{ $message }}</div> @enderror
                        </div>

                        <div class="col-12">
                            <button class="btn btn-primary" type="submit" wire:loading.attr="disabled">
                                <span wire:loading.remove>Add Post</span>
                                <span wire:loading>Saving...</span>
                            </button>
                        </div>
                    </form>
                </div>
            </div>

            {{-- List --}}
            <div class="card shadow-sm">
                <div class="card-body p-0">
                    <div class="table-responsive">
                        <table class="table table-striped table-hover mb-0">
                            <thead class="table-light">
                                <tr>
                                    <th style="width: 70px;">ID</th>
                                    <th>Title</th>
                                    <th>Content</th>
                                    <th style="width: 140px;">Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse ($posts as $post)
                                    <tr>
                                        <td>{{ $post->id }}</td>
                                        <td class="fw-semibold">{{ $post->title }}</td>
                                        <td class="text-muted">
                                            {{ \Illuminate\Support\Str::limit($post->content, 80) }}
                                        </td>
                                        <td>
                                            <a href="{{ route('posts.edit', $post) }}" class="btn btn-sm btn-outline-primary">
                                                Edit
                                            </a>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="4" class="text-center py-4 text-muted">
                                            No posts found.
                                        </td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>

                    <div class="p-3">
                        {{-- Bootstrap 5 pagination --}}
                        {{ $posts->onEachSide(1)->links() }}
                    </div>
                </div>
            </div>

        </div>
    </div>
</div>
