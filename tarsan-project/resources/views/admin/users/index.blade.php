@extends('admin.layouts.app')

@section('title', 'Manage Users')

@section('content')
<div class="flex flex-col md:flex-row md:items-center justify-between gap-4 mb-8">
    <div>
        <h1 class="text-2xl font-bold text-slate-900">User Data</h1>
        <p class="text-slate-500 mt-1">Manage user access rights and account information</p>
    </div>
    <button onclick="openUserModal('add')"
            class="inline-flex items-center gap-2 px-5 py-2.5 bg-indigo-600 text-white rounded-2xl hover:bg-indigo-700 transition duration-200 font-bold text-sm shadow-lg shadow-indigo-100">
        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path>
        </svg>
        Add User
    </button>
</div>

{{-- FILTER SECTION --}}
<div class="bg-white p-6 rounded-3xl shadow-sm border border-slate-100 mb-8">
    <form method="GET" class="grid grid-cols-1 md:grid-cols-4 gap-4 items-end">
        <div>
            <label class="block text-[10px] font-black text-slate-400 uppercase tracking-widest mb-2">Search by Name/Email</label>
            <input type="text" name="search" value="{{ request('search') }}"
                   placeholder="Type name or email..."
                   class="w-full bg-slate-50 border-none rounded-2xl px-4 py-3 focus:ring-2 focus:ring-indigo-600 text-sm outline-none transition-all">
        </div>

        <div>
            <label class="block text-[10px] font-black text-slate-400 uppercase tracking-widest mb-2">Role</label>
            <select name="role" class="w-full bg-slate-50 border-none rounded-2xl px-4 py-3 focus:ring-2 focus:ring-indigo-600 text-sm outline-none transition-all">
                <option value="">All Roles</option>
                <option value="tamu" {{ request('role')=='tamu'?'selected' : '' }}>Guest</option>
                <option value="resepsionis" {{ request('role')=='resepsionis'?'selected' : '' }}>Receptionist</option>
                @if(auth()->user()->role === 'owner')
                    <option value="admin" {{ request('role')=='admin'?'selected' : '' }}>Admin</option>
                    <option value="owner" {{ request('role')=='owner'?'selected' : '' }}>Owner</option>
                @endif
            </select>
        </div>

        <div>
            <label class="block text-[10px] font-black text-slate-400 uppercase tracking-widest mb-2">Sort By</label>
            <select name="alphabet" class="w-full bg-slate-50 border-none rounded-2xl px-4 py-3 focus:ring-2 focus:ring-indigo-600 text-sm outline-none transition-all">
                <option value="">Default</option>
                <option value="asc" {{ request('alphabet')=='asc'?'selected' : '' }}>A - Z</option>
                <option value="desc" {{ request('alphabet')=='desc'?'selected' : '' }}>Z - A</option>
            </select>
        </div>

        <div class="flex gap-2">
            <button class="flex-1 bg-slate-900 text-white px-4 py-3 rounded-2xl hover:bg-slate-800 transition font-bold text-sm shadow-sm">
                Filter
            </button>
            <a href="{{ route('admin.users.index') }}" class="px-4 py-3 bg-slate-100 text-slate-600 rounded-2xl hover:bg-slate-200 transition font-bold text-sm">
                Reset
            </a>
        </div>
    </form>
</div>

@if(session('success'))
    <div class="mb-6 p-4 bg-emerald-50 border border-emerald-200 text-emerald-700 rounded-2xl flex items-center gap-3 animate-in fade-in slide-in-from-top-4">
        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
        </svg>
        <span class="font-medium text-sm">{{ session('success') }}</span>
    </div>
@endif

<div class="bg-white rounded-3xl shadow-sm border border-slate-100 overflow-hidden">
    <div class="overflow-x-auto">
        <table class="w-full text-sm">
            <thead>
                <tr class="bg-slate-50/50 border-b border-slate-100">
                    <th class="px-6 py-4 text-left font-bold text-slate-500 uppercase tracking-wider text-[10px]">Pengguna</th>
                    <th class="px-6 py-4 text-left font-bold text-slate-500 uppercase tracking-wider text-[10px]">Email</th>
                    <th class="px-6 py-4 text-center font-bold text-slate-500 uppercase tracking-wider text-[10px]">Role</th>
                    <th class="px-6 py-4 text-right font-bold text-slate-500 uppercase tracking-wider text-[10px]">Aksi</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-slate-50">
                @forelse($users as $user)
                    <tr class="hover:bg-slate-50/50 transition duration-150">
                        <td class="px-6 py-4">
                            <div class="flex items-center gap-3">
                                <img src="{{ $user->photo ? asset('storage/'.$user->photo) : asset('images/default-avatar.png') }}"
                                     class="h-10 w-10 rounded-full object-cover ring-2 ring-slate-100"
                                     alt="{{ $user->name }}">
                                <div>
                                    <p class="font-bold text-slate-900">{{ $user->name }}</p>
                                    <p class="text-[10px] text-slate-400 font-medium italic">ID: #{{ $user->id }}</p>
                                </div>
                            </div>
                        </td>
                        <td class="px-6 py-4 text-slate-600 font-medium">{{ $user->email }}</td>
                        <td class="px-6 py-4 text-center">
                            @if($user->role === 'admin')
                                <span class="px-2 py-1 bg-red-50 text-red-600 rounded-lg text-[10px] font-black uppercase tracking-tighter">Admin</span>
                            @elseif($user->role === 'resepsionis')
                                <span class="px-2 py-1 bg-indigo-50 text-indigo-600 rounded-lg text-[10px] font-black uppercase tracking-tighter">Staff</span>
                            @elseif($user->role === 'owner')
                                <span class="px-2 py-1 bg-emerald-50 text-emerald-600 rounded-lg text-[10px] font-black uppercase tracking-tighter">Owner</span>
                            @else
                                <span class="px-2 py-1 bg-blue-50 text-blue-600 rounded-lg text-[10px] font-black uppercase tracking-tighter">Tamu</span>
                            @endif
                        </td>
                        <td class="px-6 py-4 text-right">
                            <div class="flex items-center justify-end gap-2">
                                <button onclick="openUserModal('edit', {{ json_encode($user) }})"
                                        class="p-2 text-indigo-600 hover:bg-indigo-50 rounded-xl transition duration-200" title="Edit">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15.232 5.232l3.536 3.536m-2.036-5.036a2.5 2.5 0 113.536 3.536L6.5 21.036H3v-3.572L16.732 3.732z"></path>
                                    </svg>
                                </button>
                                @if($user->id !== auth()->id())
                                <form action="{{ route('admin.users.destroy', $user) }}" method="POST" class="inline" onsubmit="return confirm('Delete this user?')">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="p-2 text-red-600 hover:bg-red-50 rounded-xl transition duration-200" title="Delete">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path>
                                        </svg>
                                    </button>
                                </form>
                                @endif
                            </div>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="4" class="px-6 py-12 text-center text-slate-400 italic">No users found.</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>

{{-- USER MODAL --}}
<div id="userModal" class="fixed inset-0 bg-slate-900/60 backdrop-blur-sm hidden z-50 flex items-center justify-center p-4">
    <div class="bg-white rounded-[2.5rem] w-full max-w-md shadow-2xl overflow-hidden transform transition-all scale-95 opacity-0 duration-300" id="userModalContent">
        <div class="p-8">
            <div class="flex justify-between items-center mb-8">
                <h2 id="userModalTitle" class="text-2xl font-black text-slate-900">Add User</h2>
                <button onclick="closeUserModal()" class="p-2 hover:bg-slate-50 rounded-full transition duration-200 text-slate-400">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                    </svg>
                </button>
            </div>

            <form id="userForm" method="POST" enctype="multipart/form-data" class="space-y-6">
                @csrf
                <input type="hidden" name="_method" id="userMethod" value="POST">

                {{-- Photo Preview --}}
                <div class="flex justify-center mb-4">
                    <div class="relative group">
                        <img id="userPhotoPreview" src="{{ asset('images/default-avatar.png') }}"
                             class="h-24 w-24 rounded-full object-cover ring-4 ring-slate-50 group-hover:ring-indigo-100 transition duration-300">
                        <label class="absolute bottom-0 right-0 p-2 bg-indigo-600 text-white rounded-full cursor-pointer shadow-lg hover:bg-indigo-700 transition">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 9a2 2 0 012-2h.93a2 2 0 001.664-.89l.812-1.22A2 2 0 0110.07 4h3.86a2 2 0 011.664.89l.812 1.22A2 2 0 0018.07 7H19a2 2 0 012 2v9a2 2 0 01-2 2H5a2 2 0 01-2-2V9z"></path>
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 13a3 3 0 11-6 0 3 3 0 016 0z"></path>
                            </svg>
                            <input type="file" name="photo" class="hidden" accept="image/*" onchange="previewUserPhoto(this)">
                        </label>
                    </div>
                </div>

                {{-- Name --}}
                <div>
                    <label class="block text-xs font-bold text-slate-400 uppercase tracking-widest mb-3">Nama Lengkap</label>
                    <input type="text" name="name" id="userName" required
                           class="w-full bg-slate-50 border-none rounded-2xl px-5 py-4 focus:ring-2 focus:ring-indigo-600 text-slate-900 font-medium placeholder-slate-400 outline-none transition-all"
                           placeholder="Contoh: John Doe">
                </div>

                {{-- Email --}}
                <div>
                    <label class="block text-xs font-bold text-slate-400 uppercase tracking-widest mb-3">Email</label>
                    <input type="email" name="email" id="userEmail" required
                           class="w-full bg-slate-50 border-none rounded-2xl px-5 py-4 focus:ring-2 focus:ring-indigo-600 text-slate-900 font-medium placeholder-slate-400 outline-none transition-all"
                           placeholder="email@contoh.com">
                </div>

                {{-- Password (Only for Add) --}}
                <div id="passwordContainer">
                    <label class="block text-xs font-bold text-slate-400 uppercase tracking-widest mb-3">Password</label>
                    <input type="password" name="password" id="userPassword"
                           class="w-full bg-slate-50 border-none rounded-2xl px-5 py-4 focus:ring-2 focus:ring-indigo-600 text-slate-900 font-medium placeholder-slate-400 outline-none transition-all"
                           placeholder="Minimal 8 karakter">
                </div>

                {{-- Role --}}
                <div>
                    <label class="block text-xs font-bold text-slate-400 uppercase tracking-widest mb-3">Access Role</label>
                    <select name="role" id="userRole" required
                            class="w-full bg-slate-50 border-none rounded-2xl px-5 py-4 focus:ring-2 focus:ring-indigo-600 text-slate-900 font-medium outline-none transition-all appearance-none cursor-pointer">
                        <option value="tamu">Guest</option>
                        <option value="resepsionis">Receptionist</option>
                        @if(auth()->user()->role === 'owner')
                            <option value="admin">Admin</option>
                            <option value="owner">Owner</option>
                        @endif
                    </select>
                </div>

                <div class="flex gap-4 pt-4">
                    <button type="button" onclick="closeUserModal()"
                            class="flex-1 px-6 py-4 border border-slate-200 text-slate-600 rounded-2xl hover:bg-slate-50 transition font-bold text-sm">
                        Cancel
                    </button>
                    <button type="submit"
                            class="flex-1 px-6 py-4 bg-slate-900 text-white rounded-2xl hover:bg-slate-800 transition shadow-xl font-bold text-sm">
                        Save Account
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

<script>
    function openUserModal(mode, user = null) {
        const modal = document.getElementById('userModal');
        const content = document.getElementById('userModalContent');
        const form = document.getElementById('userForm');
        const title = document.getElementById('userModalTitle');
        const methodInput = document.getElementById('userMethod');
        const nameInput = document.getElementById('userName');
        const emailInput = document.getElementById('userEmail');
        const roleInput = document.getElementById('userRole');
        const passwordContainer = document.getElementById('passwordContainer');
        const photoPreview = document.getElementById('userPhotoPreview');

        modal.classList.remove('hidden');
        setTimeout(() => {
            content.classList.remove('scale-95', 'opacity-0');
        }, 10);

        if (mode === 'add') {
            title.innerText = 'Add User';
            form.action = "{{ route('admin.users.store') }}";
            methodInput.value = 'POST';
            nameInput.value = '';
            emailInput.value = '';
            roleInput.value = 'tamu';
            passwordContainer.classList.remove('hidden');
            document.getElementById('userPassword').required = true;
            photoPreview.src = "{{ asset('images/default-avatar.png') }}";
        } else {
            title.innerText = 'Edit User';
            form.action = `/admin/users/${user.id}`;
            methodInput.value = 'PUT';
            nameInput.value = user.name;
            emailInput.value = user.email;
            roleInput.value = user.role;
            passwordContainer.classList.add('hidden');
            document.getElementById('userPassword').required = false;
            photoPreview.src = user.photo ? `/storage/${user.photo}` : "{{ asset('images/default-avatar.png') }}";
        }
    }

    function closeUserModal() {
        const modal = document.getElementById('userModal');
        const content = document.getElementById('userModalContent');
        content.classList.add('scale-95', 'opacity-0');
        setTimeout(() => {
            modal.classList.add('hidden');
        }, 300);
    }

    function previewUserPhoto(input) {
        if (input.files && input.files[0]) {
            const reader = new FileReader();
            reader.onload = function(e) {
                document.getElementById('userPhotoPreview').src = e.target.result;
            }
            reader.readAsDataURL(input.files[0]);
        }
    }
</script>
@endsection
