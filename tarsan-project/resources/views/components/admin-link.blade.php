@props(['route', 'label'])

@if (\Illuminate\Support\Facades\Route::has($route))
    <a href="{{ route($route) }}"
       class="block px-4 py-2.5 rounded-xl text-sm font-medium transition-all duration-200
       {{ request()->routeIs($route . '*')
            ? 'bg-indigo-50 text-indigo-700 font-semibold shadow-sm'
            : 'text-slate-600 hover:bg-slate-50 hover:text-slate-900' }}">
        {{ $label }}
    </a>
@else
    {{-- fallback to prevent errors --}}
    <span
        class="block px-4 py-2.5 rounded-xl text-sm font-medium text-slate-400 cursor-not-allowed">
        {{ $label }}
    </span>
@endif

