<x-layout>
    <x-sidebar>
        <div class="max-w-4xl mx-auto p-6 bg-gray-900 rounded-lg shadow-lg mt-8">
            <h2 class="text-4xl font-bold text-center text-white mb-8">Hasil Perhitungan ARAS</h2>

            @if (isset($K) && !empty($K) && isset($alternatif) && is_array($alternatif))
                <table class="w-full text-center text-gray-300 border-collapse border border-gray-700 rounded-lg overflow-hidden">
                    <thead class="bg-blue-700 text-white uppercase text-lg">
                        <tr>
                            <th class="px-6 py-4 border border-gray-600">Nama Alternatif</th>
                            <th class="px-6 py-4 border border-gray-600">Hasil Akhir</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($K as $index => $value)
                            <tr class="border border-gray-700 hover:bg-blue-800 transition">
                                <td class="px-6 py-4 font-semibold border border-gray-600">
                                    {{ $alternatif[$index] ?? 'Alternatif tidak ditemukan' }}
                                </td>
                                <td class="px-6 py-4 font-mono text-lg border border-gray-600">
                                    {{ number_format($value, 2) }}
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>

                @if (isset($pilih) && isset($nilai) && isset($alternatif[$pilih]))
                    <div class="mt-8 p-6 bg-blue-900 rounded-lg shadow-lg text-center text-blue-300">
                        <h3 class="text-2xl font-semibold mb-2">Alternatif Terpilih:</h3>
                        <p class="text-xl">
                            Dari hasil perhitungan dipilih <span class="font-bold text-white">{{ $alternatif[$pilih] }}</span> dengan nilai keseimbangan optimum sebesar
                            <span class="font-mono text-white">{{ number_format($nilai * 100, 2) }}%</span>
                        </p>
                    </div>
                @endif
            @else
                <div class="mt-10 p-6 bg-red-900 rounded-lg shadow-lg text-center">
                    <p class="text-3xl font-bold text-red-500 mb-4">Tidak bisa melakukan perhitungan!</p>
                    <p class="text-yellow-300 text-lg font-semibold">
                        Tolong lengkapi tabel kriteria, alternatif, dan evaluasi terlebih dahulu.
                    </p>
                </div>
            @endif
        </div>
    </x-sidebar>
</x-layout>
