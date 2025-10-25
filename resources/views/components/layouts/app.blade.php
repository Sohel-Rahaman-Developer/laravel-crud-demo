{{-- resources/views/components/layouts/app.blade.php --}}
<!doctype html>
<html lang="en">
<head>
    <meta charset="utf-8" />
    <meta
      name="viewport"
      content="width=device-width, initial-scale=1"
    />

    <title>{{ $title ?? config('app.name', 'LivewireCrudDemo') }}</title>

    {{-- Bootstrap CSS (CDN) --}}
    <link
      href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css"
      rel="stylesheet"
      integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH"
      crossorigin="anonymous"
    />
    @livewireStyles
</head>
<body class="bg-light">

    {{-- Page content --}}
    {{ $slot }}

    {{-- Toast container (Bootstrap 5) --}}
    <div class="position-fixed top-0 end-0 p-3" style="z-index: 1080">
        <div id="lw-toast" class="toast align-items-center text-bg-success border-0" role="alert" aria-live="assertive" aria-atomic="true">
            <div class="d-flex">
                <div id="lw-toast-body" class="toast-body">
                    Success
                </div>
                <button type="button" class="btn-close btn-close-white me-2 m-auto" data-bs-dismiss="toast" aria-label="Close"></button>
            </div>
        </div>
    </div>

    {{-- Bootstrap JS Bundle --}}
    <script
      src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"
      integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz"
      crossorigin="anonymous"
    ></script>

    @livewireScripts

    <script>
      // Livewire v3 browser event → Bootstrap toast
      window.addEventListener('notify', (event) => {
        const { message = 'Done', variant = 'success' } = event.detail || {};
        const toastEl = document.getElementById('lw-toast');
        const bodyEl = document.getElementById('lw-toast-body');

        if (!toastEl || !bodyEl) return;

        // set text
        bodyEl.textContent = message;

        // set color variant
        toastEl.classList.remove('text-bg-success', 'text-bg-danger', 'text-bg-info', 'text-bg-warning');
        if (variant === 'danger') toastEl.classList.add('text-bg-danger');
        else if (variant === 'info') toastEl.classList.add('text-bg-info');
        else if (variant === 'warning') toastEl.classList.add('text-bg-warning');
        else toastEl.classList.add('text-bg-success');

        const toast = new bootstrap.Toast(toastEl, { delay: 2200 });
        toast.show();
      });
    </script>
</body>
</html>
