@extends('admin.layouts.app')

@section('title', 'Users')

@section('content')
<div class="flex justify-between items-center mb-4">
    <h1 class="text-xl font-semibold">Users</h1>
</div>

{{-- FILTER --}}
<form method="GET" class="mb-4 flex flex-wrap gap-2 items-center">
    <input
        type="text"
        name="search"
        value="{{ request('search') }}"
        placeholder="Search name or email"
        class="border border-slate-200 rounded-xl px-4 py-2.5 focus:ring-2 focus:ring-slate-900 focus:border-slate-900 text-sm outline-none transition-all bg-white text-slate-800 focus:ring-2 focus:ring-indigo-600 focus:border-slate-900">

    <select
        name="role"
        class="border border-slate-200 rounded-xl px-4 py-2.5 focus:ring-2 focus:ring-slate-900 focus:border-slate-900 text-sm outline-none transition-all bg-white text-slate-800 min-w-[160px] focus:ring-2 focus:ring-indigo-600 focus:border-slate-900"
    >
        <option value="">All Roles</option>
        <option value="tamu" {{ request('role')=='tamu'?'selected' : '' }}>
            Tamu
        </option>
        <option value="resepsionis" {{ request('role')=='resepsionis'?'selected' : '' }}>
            Resepsionis
        </option>
    </select>

    <select
        name="alphabet"
        class="border border-slate-200 rounded-xl px-4 py-2.5 focus:ring-2 focus:ring-slate-900 focus:border-slate-900 text-sm outline-none transition-all bg-white text-slate-800 min-w-[140px] focus:ring-2 focus:ring-indigo-600 focus:border-slate-900"
    >
        <option value="">Default</option>
        <option value="asc" {{ request('alphabet')=='asc'?'selected' : '' }}>A - Z</option>
        <option value="desc" {{ request('alphabet')=='desc'?'selected' : '' }}>Z - A</option>
    </select>

    <button class="bg-slate-900 text-white px-5 py-2.5 rounded-xl hover:bg-slate-800 transition-colors shadow-md text-sm font-medium">
        Filter
    </button>

    <a href="{{ route('admin.users.index') }}" class="px-5 py-2.5 border border-slate-200 rounded-xl hover:bg-slate-50 transition-colors text-sm font-medium text-slate-700-xl hover:bg-slate-50">
        Reset
    </a>
</form>

@if(session('success'))
    <div class="mb-4 bg-green-50 border border-green-200 text-green-700 px-4 py-3 rounded-xl shadow-sm text-sm">
        {{ session('success') }}
    </div>
@endif

{{-- TABLE --}}
<div class="bg-white rounded-xl shadow overflow-x-auto">
    <table class="w-full text-sm">
        <thead class="bg-slate-50">
            <tr>
                <th class="px-6 py-4 text-left text-xs font-semibold text-slate-500 uppercase tracking-wider">Name</th>
                <th class="px-6 py-4 text-left text-xs font-semibold text-slate-500 uppercase tracking-wider">Email</th>
                <th class="px-6 py-4 text-left text-xs font-semibold text-slate-500 uppercase tracking-wider">Role</th>
                <th class="px-6 py-4 text-left text-xs font-semibold text-slate-500 uppercase tracking-wider">Action</th>
            </tr>
        </thead>

        <tbody>
            @forelse($users as $user)
                <tr class="border-b border-slate-100 hover:bg-slate-50 transition-colors">
                    <td class="px-6 py-4 border-b border-slate-50 text-sm">
                        <div class="flex items-center gap-2">
                            <img
                                src="{{ $user->photo ? asset('storage/'.$user->photo) : asset('images/default-avatar.png') }}"
                                class="h-8 w-8 rounded-full object-cover"
                                alt="{{ $user->name }}">
                            <span class="font-medium">{{ $user->name }}</span>
                        </div>
                    </td>

                    <td class="px-6 py-4 border-b border-slate-50 text-sm">{{ $user->email }}</td>

                    <td class="px-6 py-4 border-b border-slate-50 text-sm">
                        <span class="px-2 py-1 text-xs rounded-full {{ $user->role === 'tamu' ? 'bg-blue-100 text-blue-700' : 'bg-yellow-100 text-yellow-700' }}">
                            {{ $user->role === 'tamu' ? 'Tamu' : 'Resepsionis' }}
                        </span>
                    </td>

                    <td class="px-6 py-4 border-b border-slate-50 text-sm">
                        <div class="flex items-center gap-3">
                            <a href="{{ route('admin.users.edit', $user) }}"
                               class="text-indigo-600 hover:underline text-xs font-medium">
                                Edit
                            </a>

                            <form method="POST"
                                  action="{{ route('admin.users.destroy', $user) }}"
                                  onsubmit="return confirm('Hapus user ini?')">
                                @csrf
                                @method('DELETE')
                                <button class="text-red-600 hover:underline text-xs font-medium">
                                    Delete
                                </button>
                            </form>
                        </div>
                    </td>
                </tr>
            @empty
                <tr>
                    <td colspan="4" class="p-6 text-center text-slate-500">
                        No users found
                    </td>
                </tr>
            @endforelse
        </tbody>
    </table>
</div>

@if($users->hasPages())
    <div class="mt-4">
        {{ $users->links() }}
    </div>
@endif
@endsection
