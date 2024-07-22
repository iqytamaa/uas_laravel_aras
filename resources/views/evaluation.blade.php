<x-layout>
    <x-sidebar>
        <div class="relative overflow-x-auto shadow-md sm:rounded-lg">
            <form action="{{ route('evaluations.update') }}" method="POST">
                @csrf
                @method('PUT')
                <table class="w-full text-sm rtl:text-right text-gray-500 dark:text-gray-400 text-center">
                    <thead class="text-xs text-gray-700 uppercase bg-gray-50 dark:bg-gray-700 dark:text-gray-400">
                        <tr>
                            <th scope="col" class="px-6 py-3">
                                Nama Alternatif
                            </th>
                            @foreach ($criterias as $criteria)
                                <th scope="col" class="px-6 py-3">
                                    {{ $criteria->criteria }}
                                </th>
                            @endforeach
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($alternatives as $alternative)
                            <tr class="border-b bg-gray-800 border-gray-700">
                                <th scope="row"
                                    class="px-6 py-4 font-medium text-gray-900 whitespace-nowrap dark:text-white">
                                    {{ $alternative->name }}
                                </th>
                                @foreach ($criterias as $criteria)
                                    @php
                                        $evaluation = $evaluations
                                            ->where('id_alternative', $alternative->id_alternative)
                                            ->where('id_criteria', $criteria->id_criteria)
                                            ->first();
                                    @endphp
                                    <td class="px-6 py-4">
                                        <input type="number"
                                            name="evaluations[{{ $alternative->id_alternative }}][{{ $criteria->id_criteria }}]"
                                            value="{{ $evaluation ? $evaluation->value : '' }}"
                                            class="form-input text-gray-200 w-25 h-10 text-center bg-gray-900 rounded-lg">
                                    </td>
                                @endforeach
                            </tr>
                        @endforeach
                    </tbody>
                </table>
                <button type="submit" class="mt-4 px-4 py-2 bg-blue-600 text-white rounded">Update</button>
            </form>
        </div>
    </x-sidebar>
</x-layout>
