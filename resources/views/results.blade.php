<x-layout>
    <x-sidebar>
        <h2 class="text-4xl text-gray-200 text-center font-bold">Hasil Perhitungan ARAS</h2>
        <div class="relative overflow-x-auto shadow-md sm:rounded-lg p-4">
            <table class="w-full text-sm rtl:text-right text-gray-500 dark:text-gray-400 text-center">
                <thead class="text-base text-gray-700 uppercase bg-gray-50 dark:bg-gray-700 dark:text-gray-400">
                    <tr>
                        <th scope="col" class="px-6 py-3">
                            Nama Alternatif
                        </th>
                        <th scope="col" class="px-6 py-3">
                            Hasil Akhir
                        </th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($K as $index => $value)
                        <tr class="border-b bg-gray-800 border-gray-700">
                            <th scope="row" class="px-6 py-4 font-medium text-gray-200 whitespace-nowrap text-base">
                                {{ $alternatif[$index] }}
                            </th>
                            <td class="px-6 py-4 text-gray-200 text-base">
                                {{ number_format($value, 2) }}
                            </td>
                    @endforeach
                    </tr>
                </tbody>
            </table>

            <h3 class="text-xl font-semibold mb-2 text-gray-200 mt-5">Alternatif Terpilih:</h3>
            <p class="text-gray-200">
                Dari hasil perhitungan dipilih {{ $alternatif[$pilih] }} dengan nilai keseimbangan optimum
                sebesar {{ number_format($nilai * 100, 2) }} %
            </p>
        </div>
    </x-sidebar>
</x-layout>
