<div x-data="{ modalHapus: null }">
    <!-- ...tabel dan tombol hapus... -->
    <!-- Modal Konfirmasi Hapus -->
    <template x-if="modalHapus">
        <div class="fixed inset-0 z-50 flex items-center justify-center bg-black bg-opacity-40">
            <div class="bg-white rounded-lg shadow-lg p-6 w-full max-w-md animate-fade-in">
                <div class="flex items-center mb-4">
                    <i class="fas fa-exclamation-triangle text-red-500 text-3xl mr-3"></i>
                    <h3 class="text-lg font-bold text-gray-800">Konfirmasi Hapus</h3>
                </div>
                <p class="mb-6 text-gray-700">Apakah Anda yakin ingin menghapus field ini? Tindakan ini tidak dapat dibatalkan.</p>
                <div class="flex justify-end gap-2">
                    <button @click="modalHapus = null" class="px-4 py-2 bg-gray-200 text-gray-700 rounded hover:bg-gray-300">Batal</button>
                    <form :action="'{{ url('/admin-desa/letter-fields') }}/' + modalHapus" method="POST" @submit="modalHapus = null">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="px-4 py-2 bg-red-600 text-white rounded hover:bg-red-700 font-semibold">Hapus</button>
                    </form>
                </div>
            </div>
        </div>
    </template>
</div> 