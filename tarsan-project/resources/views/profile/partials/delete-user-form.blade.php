<section>
    <header class="mb-6">
        <h2 class="text-xl font-semibold text-red-600 flex items-center gap-2">
            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path>
            </svg>
            Hapus Akun
        </h2>
        <p class="mt-1 text-sm text-gray-500">
            Setelah akun dihapus, semua data akan dihapus secara permanen. Harap pertimbangkan baik-baik sebelum melanjutkan.
        </p>
    </header>

    <button type="button"
        onclick="showDeleteModal()"
        class="px-5 py-2.5 bg-red-600 text-white rounded-lg hover:bg-red-700 transition duration-200 font-medium text-sm">
        Hapus Akun
    </button>

    {{-- Modal Konfirmasi --}}
    <div id="deleteAccountModal" class="hidden fixed inset-0 bg-black bg-opacity-50 z-50 flex items-center justify-center p-4">
        <div class="bg-white p-6 rounded-lg shadow-lg max-w-md w-full">
            <h3 class="text-lg font-semibold text-gray-900 mb-2">Konfirmasi Hapus Akun</h3>
            <p class="text-sm text-gray-600 mb-4">
                Apakah Anda yakin ingin menghapus akun? Semua data akan hilang secara permanen.
            </p>

            <form method="post" action="{{ route('profile.destroy') }}" class="space-y-4">
                @csrf
                @method('delete')

                <div>
                    <label for="delete_password" class="block text-sm font-medium text-gray-700 mb-1">Masukkan Password</label>
                    <input
                        id="delete_password"
                        name="password"
                        type="password"
                        class="w-full px-4 py-2 border border-gray-300 rounded-lg text-sm focus:ring-2 focus:ring-red-500 focus:border-transparent outline-none transition"
                        placeholder="Password Anda"
                        required />
                    <x-input-error :messages="$errors->userDeletion->get('password')" class="mt-2" />
                </div>

                <div class="flex gap-3">
                    <button type="button"
                        onclick="hideDeleteModal()"
                        class="flex-1 px-4 py-2 bg-gray-200 text-gray-700 rounded-lg hover:bg-gray-300 transition duration-200 font-medium text-sm">
                        Batal
                    </button>
                    <button type="submit"
                        class="flex-1 px-4 py-2 bg-red-600 text-white rounded-lg hover:bg-red-700 transition duration-200 font-medium text-sm">
                        Hapus Akun
                    </button>
                </div>
            </form>
        </div>
    </div>

    <script>
    function showDeleteModal() {
        document.getElementById('deleteAccountModal').classList.remove('hidden');
    }
    function hideDeleteModal() {
        document.getElementById('deleteAccountModal').classList.add('hidden');
    }
    </script>
</section>
