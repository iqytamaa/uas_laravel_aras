<x-layout>
    <x-sidebar>
        <div class="p-6 bg-gray-900 text-white min-h-screen">

            <h1 class="text-3xl font-bold mb-6">Daftar Kriteria</h1>

            @if(session('success'))
                <div class="bg-green-600 p-3 rounded mb-4">
                    {{ session('success') }}
                </div>
            @endif

            <!-- Form Tambah Kriteria -->
            <form action="{{ route('criteria.store') }}" method="POST" class="mb-6 form-simpan">
                @csrf
                <input type="text" name="criteria_name" placeholder="Nama Kriteria" required
                    class="p-2 rounded bg-gray-800 text-white w-full mb-2" />
                <select name="criteria_attribute" required class="p-2 rounded bg-gray-800 text-white w-full mb-2">
                    <option value="cost">cost</option>
                    <option value="benefit">benefit</option>
                </select>
                <input type="number" step="0.01" name="criteria_weight" placeholder="Bobot Kriteria" required
                    class="p-2 rounded bg-gray-800 text-white w-full mb-4" />
                <button type="submit" class="bg-blue-600 px-4 py-2 rounded hover:bg-blue-700">Tambah Kriteria</button>
            </form>

            <!-- Tabel Daftar Kriteria -->
            <table class="w-full text-left border-collapse border border-gray-700">
                <thead>
                    <tr>
                        <th class="border border-gray-600 p-2">No</th>
                        <th class="border border-gray-600 p-2">Nama Kriteria</th>
                        <th class="border border-gray-600 p-2">Jenis Kriteria</th>
                        <th class="border border-gray-600 p-2">Bobot Kriteria</th>
                        <th class="border border-gray-600 p-2">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($criterias as $index => $criteria)
                        <tr>
                            <form action="{{ route('criteria.update', $criteria->id_criteria) }}" method="POST" class="form-simpan">
                                @csrf
                                @method('PUT')
                                <td class="border border-gray-600 p-2">{{ $index + 1 }}</td>
                                <td class="border border-gray-600 p-2">
                                    <input type="text" name="criteria_name" value="{{ $criteria->criteria }}" required
                                        class="w-full p-1 rounded bg-gray-800 text-white" />
                                </td>
                                <td class="border border-gray-600 p-2">
                                    <select name="criteria_attribute" required class="w-full p-1 rounded bg-gray-800 text-white">
                                        <option value="cost" {{ $criteria->attribute == 'cost' ? 'selected' : '' }}>cost</option>
                                        <option value="benefit" {{ $criteria->attribute == 'benefit' ? 'selected' : '' }}>benefit</option>
                                    </select>
                                </td>
                                <td class="border border-gray-600 p-2">
                                    <input type="number" step="0.01" name="criteria_weight" value="{{ $criteria->weight }}" required
                                        class="w-full p-1 rounded bg-gray-800 text-white" />
                                </td>
                                <td class="border border-gray-600 p-2">
                                    <button type="submit" class="bg-green-600 px-3 py-1 rounded hover:bg-green-700">Simpan</button>
                            </form>
                            <form action="{{ route('criteria.destroy', $criteria->id_criteria) }}" method="POST" class="inline-block ml-2 form-hapus">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="bg-red-600 px-3 py-1 rounded hover:bg-red-700">Hapus</button>
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
    