@extends('admin.layouts.app')

@section('title', 'Users')

@section('content')

<h1 class="text-xl font-semibold mb-4">Users</h1>

{{-- FILTER --}}
<form method="GET" class="mb-4 flex flex-wrap gap-2 items-center">

    <input
        type="text"
        name="search"
        value="{{ request('search') }}"
        placeholder="Search name or email"
        class="border rounded px-3 py-2">

        <select
            name="role"
            class="border rounded px-3 py-2 min-w-[160px]"
        >
            <option value="">All Roles</option>
            <option value="tamu" {{ request('role')=='tamu'?'selected':'' }}>
                Tamu
            </option>
            <option value="resepsionis" {{ request('role')=='resepsionis'?'selected':'' }}>
                Resepsionis
            </option>
        </select>

        <select
            name="alphabet"
            class="border rounded px-3 py-2 min-w-[140px]"
        >
            <option value="">Default</option>
            <option value="asc">A - Z</option>
            <option value="desc">Z - A</option>
        </select>


    <button class="bg-blue-600 text-white px-4 py-2 rounded">
        Filter
    </button>
</form>

@if(session('success'))
    <div class="mb-4 bg-green-100 text-green-700 p-3 rounded">
        {{ session('success') }}
    </div>
@endif

{{-- TABLE --}}
<div class="bg-white rounded shadow overflow-x-auto">
<table class="w-full text-sm">
    <thead class="bg-gray-100">
        <tr>
            <th class="p-3">Name</th>
            <th>Email</th>
            <th>Role</th>
            <th class="p-3">Action</th>
        </tr>
    </thead>

    <tbody>
        @forelse($users as $user)
            <tr class="border-t">
                <td class="p-3 flex items-center gap-2">
                    <img
                        src="{{ $user->photo ? asset('storage/'.$user->photo) : asset('images/default-avatar.png') }}"
                        class="h-8 w-8 rounded-full object-cover">

                    {{ $user->name }}
                </td>

                <td>{{ $user->email }}</td>

                <td>
                    @if($user->role === 'tamu')
                        <span class="px-2 py-1 text-xs rounded bg-blue-100 text-blue-700">
                            Tamu
                        </span>
                    @else
                        <span class="px-2 py-1 text-xs rounded bg-yellow-100 text-yellow-700">
                            Resepsionis
                        </span>
                    @endif
                </td>

                <td class="p-3 flex gap-2">
                    <a href="{{ route('admin.users.edit', $user) }}"
                       class="text-blue-600 hover:underline">
                        Edit
                    </a>

                    <form method="POST"
                          action="{{ route('admin.users.destroy', $user) }}"
                          onsubmit="return confirm('Hapus user ini?')">
                        @csrf
                        @method('DELETE')
                        <button class="text-red-600 hover:underline">
                            Delete
                        </button>
                    </form>
                </td>
            </tr>
        @empty
            <tr>
                <td colspan="4" class="p-4 text-center text-gray-500">
                    No users found
                </td>
            </tr>
        @endforelse
    </tbody>
</table>
</div>

<div class="mt-4">
    {{ $users->links() }}
</div>

@endsection
