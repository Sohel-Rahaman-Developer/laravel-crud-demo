<div class="container py-5">
    <div class="row justify-content-center">
        <div class="col-lg-6">
            <div class="card shadow-sm">
                <div class="card-body">
                    <h1 class="h4 mb-3">Livewire is working ✅</h1>
                    <p class="text-muted mb-4">
                        Ye button Livewire ke through without page reload count badhata hai.
                    </p>

                    <button wire:click="increment" class="btn btn-primary">
                        Count: {{ $count }}
                    </button>

                    <div class="alert alert-info mt-4 mb-0">
                        If the count increases on click, Livewire setup is successful.
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
