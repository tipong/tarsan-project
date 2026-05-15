@extends('admin.layouts.app')

@section('title', 'Edit User')

@section('content')
<div class="max-w-lg">
    <h1 class="text-xl font-semibold mb-4">Edit User</h1>

    @if ($errors->any())
        <div class="bg-red-100 text-red-700 p-3 rounded-xl mb-4">
            <ul class="list-disc pl-5">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form method="POST"
          action="{{ route('admin.users.update', $user) }}"
          class="bg-white p-6 rounded-xl shadow"
          enctype="multipart/form-data">
        @csrf
        @method('PUT')

        <div class="space-y-6">
            <div>
                <label class="block text-sm font-medium text-slate-800 font-semibold mb-2">Name</label>
                <input name="name"
                       value="{{ old('name', $user->name) }}"
                       class="w-full border border-slate-200 rounded-xl px-4 py-2.5 focus:ring-2 focus:ring-slate-900 focus:border-slate-900 text-sm outline-none transition-all"
                       required>
            </div>

            <div>
                <label class="block text-sm font-medium text-slate-800 font-semibold mb-2">Email</label>
                <input name="email"
                       type="email"
                       value="{{ old('email', $user->email) }}"
                       class="w-full border border-slate-200 rounded-xl px-4 py-2.5 focus:ring-2 focus:ring-slate-900 focus:border-slate-900 text-sm outline-none transition-all"
                       required>
            </div>

            <div>
                <label class="block text-sm font-medium text-slate-800 font-semibold mb-2">Role</label>
                <select name="role"
                        class="w-full border border-slate-200 rounded-xl px-4 py-2.5 focus:ring-2 focus:ring-slate-900 focus:border-slate-900 text-sm outline-none transition-all">
                    <option value="tamu" {{ $user->role=='tamu'?'selected' : '' }}>Guest</option>
                    <option value="resepsionis" {{ $user->role=='resepsionis'?'selected' : '' }}>
                        Receptionist
                    </option>
                </select>
            </div>

            <div>
                <label class="block text-sm font-medium text-slate-800 font-semibold mb-2">Photo</label>
                @if($user->photo)
                    <div class="mb-2">
                        <img src="{{ asset('storage/' . $user->photo) }}"
                             class="h-20 w-20 rounded-full object-cover"
                             alt="Current photo">
                    </div>
                @endif
                <input type="file"
                       name="photo"
                       accept="image/*"
                       class="w-full border border-slate-200 rounded-xl px-4 py-2.5 focus:ring-2 focus:ring-slate-900 focus:border-slate-900 text-sm outline-none transition-all bg-white text-slate-800 file:mr-4 file:py-2 file:px-4 file:rounded-xl file:border-0 file:text-sm file:bg-indigo-50 file:text-blue-700 hover:file:bg-blue-100">
                <p class="mt-1 text-xs text-slate-500">Leave empty to keep current photo</p>
            </div>

            <div class="pt-2 flex items-center gap-3">
                <button type="submit" class="bg-slate-900 text-white px-6 py-2.5 rounded-xl hover:bg-slate-800 transition-colors shadow-sm text-sm font-medium-xl hover:bg-slate-800">
                    Update
                </button>
                <a href="{{ route('admin.users.index') }}" class="text-slate-600 hover:underline">
                    Cancel
                </a>
            </div>
        </div>
    </form>
</div>
@endsection
