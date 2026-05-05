@extends('admin.layouts.app')

@section('title', 'Edit User')

@section('content')

<form method="POST"
      action="{{ route('admin.users.update', $user) }}"
      class="bg-white p-6 rounded shadow max-w-lg">
@csrf
@method('PUT')

<div class="space-y-4">

    <input
        name="name"
        value="{{ old('name', $user->name) }}"
        class="w-full border rounded p-2"
        required>

    <input
        name="email"
        type="email"
        value="{{ old('email', $user->email) }}"
        class="w-full border rounded p-2"
        required>

    <select name="role" class="w-full border rounded p-2">
        <option value="tamu" {{ $user->role=='tamu'?'selected':'' }}>Tamu</option>
        <option value="resepsionis" {{ $user->role=='resepsionis'?'selected':'' }}>
            Resepsionis
        </option>
    </select>

    <button class="bg-blue-600 text-white px-4 py-2 rounded">
        Update
    </button>

</div>
</form>

@endsection
