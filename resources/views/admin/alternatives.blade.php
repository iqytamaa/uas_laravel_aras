<x-layout>
    <x-sidebar>
        <div class="relative overflow-x-auto shadow-md sm:rounded-lg">

            <!-- Form Tambah Alternatif -->
                    <form action="{{ route('alternatives.store') }}" method="POST" class="mb-4 form-simpan">
                @csrf
                <div class="mb-4">
                    <label for="alternative_name" class="block text-sm font-medium text-gray-200">Nama Alternatif</label>
                    <input
                        type="text"
                        name="alternative_name"
                        id="alternative_name"
                        required
                        placeholder="Masukkan nama alternatif"
                        class="mt-1 block w-full p-2 rounded-xl bg-white text-black border border-gray-300"
                    >
                </div>
                <button type="submit" class="px-4 py-2 bg-blue-600 text-white rounded">Tambah Alternatif</button>
            </form>

            <!-- Tabel Alternatif -->
            <table class="w-full text-sm text-left rtl:text-right text-gray-500 dark:text-gray-400">
                <thead class="text-xs text-gray-700 uppercase bg-gray-50 dark:bg-gray-700 dark:text-gray-400">
                    <tr>
                        <th scope="col" class="px-6 py-3">No.</th>
                        <th scope="col" class="px-6 py-3">Nama Alternatif</th>
                        <th scope="col" class="px-6 py-3">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($alternatives as $index => $alternative)
                        <tr class="bg-white border-b dark:bg-gray-800 dark:border-gray-700">
                            <form action="{{ route('alternatives.update', $alternative->id_alternative) }}" method="POST" class="form-simpan">
                                @csrf
                                @method('PUT')
                                <th scope="row" class="px-6 py-4 font-medium text-gray-900 whitespace-nowrap dark:text-white">
                                    {{ $index + 1 }}
                                </th>
                                <td class="px-6 py-4">
                                    <input type="text" name="alternative_name" value="{{ $alternative->name }}" required
                                        class="block w-full text-gray-200 bg-gray-900 p-2 rounded-xl">
                                </td>
                                <td class="px-6 py-4 flex space-x-2">
                                    <button type="submit" class="px-4 py-2 bg-green-600 text-white rounded">Simpan</button>
                            </form>
                            <form action="{{ route('alternatives.destroy', $alternative->id_alternative) }}" method="POST" class="form-hapus" onsubmit="return false;">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="px-4 py-2 bg-red-600 text-white rounded">Hapus</button>
                            </form>
                        </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </x-sidebar>

    <!-- SweetAlert2 Script -->
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            // Konfirmasi Simpan
            document.querySelectorAll('.form-simpan').forEach(function(form) {
                form.addEventListener('submit', function(e) {
                    e.preventDefault();
                    Swal.fire({
                        title: 'Simpan perubahan?',
                        icon: 'question',
                        showCancelButton: true,
                        confirmButtonText: 'Ya, simpan',
                        cancelButtonText: 'Batal',
                    }).then((result) => {
                        if (result.isConfirmed) {
                            form.submit();
                        }
                    });
                });
            });

            // Konfirmasi Hapus
            document.querySelectorAll('.form-hapus').forEach(function(form) {
                form.addEventListener('submit', function(e) {
                    e.preventDefault();
                    Swal.fire({
                        title: 'Yakin ingin menghapus?',
                        text: "Data yang dihapus tidak bisa dikembalikan!",
                        icon: 'warning',
                        showCancelButton: true,
                        confirmButtonText: 'Ya, hapus',
                        cancelButtonText: 'Batal',
                    }).then((result) => {
                        if (result.isConfirmed) {
                            form.submit();
                        }
                    });
                });
            });
        });
    </script>
</x-layout>
