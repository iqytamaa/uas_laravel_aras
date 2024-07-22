<x-layout>
    <x-sidebar>
        <div class="relative overflow-x-auto shadow-md sm:rounded-lg">

            <!-- Form Tambah Kriteria -->
            <form action="{{ route('criterias.store') }}" method="POST" class="mb-4">
                @csrf
                <div class="mb-4">
                    <label for="criteria_name" class="block text-sm font-medium text-gray-200">Nama Kriteria</label>
                    <input type="text" name="criteria_name" id="criteria_name" required
                        class="mt-1 block w-full p-2 rounded-xl">
                </div>
                <div class="mb-4">
                    <label for="criteria_attribute" class="block text-sm font-medium text-gray-200">Jenis
                        Kriteria</label>
                    <select name="criteria_attribute" required class=" mt-1 block w-full text-gray-900 p-2 rounded-xl">
                        <option value="cost">
                            cost</option>
                        <option value="benefit">benefit
                        </option>
                    </select>
                </div>
                <div class="mb-4">
                    <label for="criteria_weight" class="block text-sm font-medium text-gray-200">Bobot Kriteria</label>
                    <input type="number" step="0.01" name="criteria_weight" id="criteria_weight" required
                        class="mt-1 block w-full p-2 rounded-xl">
                </div>
                <button type="submit" class="px-4 py-2 bg-blue-600 text-white rounded">Tambah Kriteria</button>
            </form>

            <!-- Tabel Kriteria -->
            <table class="w-full text-sm text-left rtl:text-right text-gray-500 dark:text-gray-400">
                <thead class="text-xs text-gray-700 uppercase bg-gray-50 dark:bg-gray-700 dark:text-gray-400">
                    <tr>
                        <th scope="col" class="px-6 py-3">
                            Nomor
                        </th>
                        <th scope="col" class="px-6 py-3">
                            Nama Kriteria
                        </th>
                        <th scope="col" class="px-6 py-3">
                            Jenis Kriteria
                        </th>
                        <th scope="col" class="px-6 py-3">
                            Bobot Kriteria
                        </th>
                        <th scope="col" class="px-6 py-3">
                            Aksi
                        </th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($criterias as $index => $criteria)
                        <tr class="bg-white border-b dark:bg-gray-800 dark:border-gray-700">
                            <form action="{{ route('criterias.update', $criteria->id_criteria) }}" method="POST">
                                @csrf
                                @method('PUT')
                                <td class="px-6 py-4 font-medium text-gray-900 whitespace-nowrap dark:text-white">
                                    {{ $index + 1 }}
                                </td>
                                <td class="px-6 py-4">
                                    <input type="text" name="criteria_name" value="{{ $criteria->criteria }}"
                                        required class="block w-full text-gray-200 bg-gray-900 p-2 rounded-xl">
                                </td>
                                <td class="px-6 py-4">
                                    <select name="criteria_attribute" required
                                        class="block w-full text-gray-200 bg-gray-900 p-2 rounded-xl">
                                        <option value="cost" {{ $criteria->attribute == 'cost' ? 'selected' : '' }}>
                                            cost</option>
                                        <option value="benefit"
                                            {{ $criteria->attribute == 'benefit' ? 'selected' : '' }}>benefit</option>
                                    </select>
                                </td>
                                <td class="px-6 py-4">
                                    <input type="number" step="0.01" name="criteria_weight"
                                        value="{{ $criteria->weight }}" required
                                        class="block w-full text-gray-200 bg-gray-900 p-2 rounded-xl">
                                </td>
                                <td class="px-6 py-4 flex space-x-2">
                                    <button type="submit"
                                        class="px-4 py-2 bg-green-600 text-white rounded">Simpan</button>
                            </form>
                            <form action="{{ route('criterias.destroy', $criteria->id_criteria) }}" method="POST">
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
</x-layout>
