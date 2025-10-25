<div class="container py-4">
    <div class="row justify-content-center">
        <div class="col-lg-8">

            <div class="d-flex align-items-center justify-content-between mb-3">
                <h1 class="h4 m-0">Edit Post #{{ $post->id }}</h1>
                <a href="{{ route('posts.index') }}" class="btn btn-outline-secondary">← Back to list</a>
            </div>

            <div class="card shadow-sm">
                <div class="card-body">
                    <form wire:submit.prevent="update" class="row g-3">
                        <div class="col-12">
                            <label class="form-label">Title <span class="text-danger">*</span></label>
                            <input type="text" class="form-control" wire:model.defer="title" />
                            @error('title') <div class="text-danger small mt-1">{{ $message }}</div> @enderror
                        </div>

                        <div class="col-12">
                            <label class="form-label">Content</label>
                            <textarea class="form-control" rows="5" wire:model.defer="content"></textarea>
                            @error('content') <div class="text-danger small mt-1">{{ $message }}</div> @enderror
                        </div>

                        <div class="col-12 d-flex gap-2">
                            <button class="btn btn-primary" type="submit" wire:loading.attr="disabled">
                                <span wire:loading.remove>Save Changes</span>
                                <span wire:loading>Saving...</span>
                            </button>

                            <button type="button" class="btn btn-outline-danger"
                                    wire:click="delete"
                                    wire:confirm="Delete this post?">
                                Delete
                            </button>
                        </div>
                    </form>
                </div>
            </div>

        </div>
    </div>
</div>
