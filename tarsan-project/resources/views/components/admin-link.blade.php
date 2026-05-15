@props(['route', 'label'])

@if (\Illuminate\Support\Facades\Route::has($route))
    <a href="{{ route($route) }}"
       class="block px-3 py-2 rounded
       {{ request()->routeIs($route . '*')
            ? 'bg-blue-100 text-blue-700 font-semibold'
            : 'text-gray-700 hover:bg-gray-100' }}">
        {{ $label }}
    </a>
@else
    {{-- fallback to prevent errors --}}
    <span
        class="block px-3 py-2 rounded text-gray-400 cursor-not-allowed">
        {{ $label }}
    </span>
@endif
