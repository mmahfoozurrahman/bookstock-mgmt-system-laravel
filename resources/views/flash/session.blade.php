@if ($message = session('success'))
    <div class="mb-6 rounded-md bg-green-50 p-4 text-sm text-green-700 ring-1 ring-green-600/20">
        {{ $message }}
    </div>
@endif

@if ($message = session('error'))
    <div class="mb-6 rounded-md bg-red-50 p-4 text-sm text-red-700 ring-1 ring-red-600/20">
        {{ $message }}
    </div>
@endif