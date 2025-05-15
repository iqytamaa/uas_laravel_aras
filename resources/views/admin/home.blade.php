<x-layout>
    <x-sidebar>
        <div class="p-6 bg-gray-900 text-white min-h-screen">
            <h1 class="text-3xl font-bold mb-6">Selamat datang di Halaman Home!</h1>
            <p>Ini adalah halaman utama setelah login.</p>

            <h2 class="text-xl font-semibold mt-8 mb-4">Daftar Kriteria</h2>
            <ul class="list-disc list-inside space-y-1">
                @foreach ($criterias as $criteria)
                    <li>{{ $criteria->criteria ?? 'Nama Kriteria' }}</li>
                @endforeach
            </ul>
        </div>
    </x-sidebar>
</x-layout>
