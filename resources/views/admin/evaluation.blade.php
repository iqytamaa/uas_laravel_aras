<x-layout>
    <x-sidebar>
        <div class="relative overflow-x-auto shadow-md sm:rounded-lg">

            <form id="form-evaluasi"
                  action="{{ route('evaluation.update') }}"
                  method="POST">
                @csrf
                @method('PUT')

                <table class="w-full text-center text-gray-500 dark:text-gray-400">
                    <thead class="bg-gray-50 dark:bg-gray-700 dark:text-gray-400">
                        <tr>
                            <th class="px-6 py-3">Nama Alternatif</th>
                            @foreach ($criterias as $criteria)
                                <th class="px-6 py-3">{{ $criteria->criteria }}</th>
                            @endforeach
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($alternatives as $alternative)
                            <tr class="border-b bg-gray-800 border-gray-700">
                                <th class="px-6 py-4 text-white">
                                    {{ $alternative->name }}
                                </th>
                                @foreach ($criterias as $criteria)
                                    @php
                                        $eval = $evaluations
                                            ->where('id_alternative', $alternative->id_alternative)
                                            ->where('id_criteria', $criteria->id_criteria)
                                            ->first();
                                    @endphp
                                    <td class="px-6 py-4">
                                        <input type="number"
                                               name="evaluations[{{ $alternative->id_alternative }}][{{ $criteria->id_criteria }}]"
                                               value="{{ $eval?->value ?? '' }}"
                                               required
                                               class="w-20 h-10 text-center bg-gray-900 text-white rounded-lg">
                                    </td>
                                @endforeach
                            </tr>
                        @endforeach
                    </tbody>
                </table>

                <button type="submit"
                        class="mt-4 px-4 py-2 bg-blue-600 text-white rounded hover:bg-blue-700">
                    Update
                </button>
            </form>
        </div>
    </x-sidebar>

    <!-- SweetAlert2 -->
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script>
        document.getElementById('form-evaluasi')
            .addEventListener('submit', function(e) {
                e.preventDefault();
                Swal.fire({
                    title: 'Update data evaluasi?',
                    icon: 'question',
                    showCancelButton: true,
                    confirmButtonText: 'Ya, update',
                    cancelButtonText: 'Batal',
                }).then((res) => {
                    if (res.isConfirmed) {
                        e.target.submit();
                    }
                });
            });
    </script>
</x-layout>
