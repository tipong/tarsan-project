<section>
    <header class="mb-6">
        <h2 class="text-xl font-semibold text-gray-900 flex items-center gap-2">
            <svg class="w-5 h-5 text-gray-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path>
            </svg>
            Informasi Profile
        </h2>
        <p class="mt-1 text-sm text-gray-500">
            Perbarui informasi profile dan email akun Anda.
        </p>
    </header>

    <form method="post"
          action="{{ route('profile.update') }}"
          enctype="multipart/form-data"
          class="space-y-6">
        @csrf
        @method('patch')

        {{-- FOTO PROFILE --}}
        <div>
            <label class="block text-sm font-medium text-gray-700 mb-2">Foto Profile</label>
            <div class="flex items-center gap-4">
                <img
                    id="photoPreview"
                    src="{{ $user->photo
                        ? asset('storage/' . $user->photo)
                        : asset('images/default-avatar.png') }}"
                    class="h-20 w-20 rounded-full object-cover border-2 border-gray-200">

                <div class="flex-1">
                    <input
                        type="file"
                        id="photo"
                        name="photo"
                        accept="image/*"
                        class="block w-full text-sm text-gray-500
                            file:mr-4 file:py-2 file:px-4
                            file:rounded-lg file:border-0
                            file:text-sm file:font-medium
                            file:bg-blue-50 file:text-blue-600
                            hover:file:bg-blue-100"
                        onchange="previewPhoto(event)">
                    <p class="text-xs text-gray-400 mt-1">JPG, PNG atau GIF. Maksimal 2MB.</p>
                </div>
            </div>
            <x-input-error class="mt-2" :messages="$errors->get('photo')" />
        </div>

        {{-- NAMA --}}
        <div>
            <label for="name" class="block text-sm font-medium text-gray-700 mb-1">Nama Lengkap</label>
            <input
                id="name"
                name="name"
                type="text"
                class="w-full px-4 py-2 border border-gray-300 rounded-lg text-sm focus:ring-2 focus:ring-blue-500 focus:border-transparent outline-none transition"
                value="{{ old('name', $user->name) }}"
                required autofocus />
            <x-input-error class="mt-2" :messages="$errors->get('name')" />
        </div>

        {{-- EMAIL --}}
        <div>
            <label for="email" class="block text-sm font-medium text-gray-700 mb-1">Email</label>
            <input
                id="email"
                name="email"
                type="email"
                class="w-full px-4 py-2 border border-gray-300 rounded-lg text-sm focus:ring-2 focus:ring-blue-500 focus:border-transparent outline-none transition"
                value="{{ old('email', $user->email) }}"
                required />
            <x-input-error class="mt-2" :messages="$errors->get('email')" />
        </div>

        {{-- SIMPAN --}}
        <div class="flex items-center gap-4 pt-4 border-t border-gray-100">
            <button type="submit"
                class="px-6 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700 transition duration-200 font-medium text-sm">
                Simpan Perubahan
            </button>

            @if (session('status') === 'profile-updated')
                <p class="text-sm text-green-600 flex items-center gap-1">
                    <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 20 20">
                        <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"></path>
                    </svg>
                    Tersimpan.
                </p>
            @endif
        </div>
    </form>

    <script>
    function previewPhoto(event) {
        const input = event.target;
        const preview = document.getElementById('photoPreview');

        if (input.files && input.files[0]) {
            const reader = new FileReader();

            reader.onload = function (e) {
                preview.src = e.target.result;
            };

            reader.readAsDataURL(input.files[0]);
        }
    }
    </script>
</section>
