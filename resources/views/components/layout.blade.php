<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <title>ARAS</title>
    @vite('resources/css/app.css')
</head>

<body class="w-full h-full bg-gray-900 flex">

    @auth
        <!-- Sidebar hanya tampil jika user sudah login -->
        <aside id="default-sidebar" class="fixed top-0 left-0 z-40 w-64 h-screen bg-gray-900 text-gray-200 overflow-y-auto">
            <div class="px-4 py-6">
                <h1 class="text-xl font-bold mb-6">Metode ARAS</h1>
                <ul class="space-y-2 font-medium">
                    <li>
                        <a href="/home" class="block p-2 rounded hover:bg-gray-700 {{ request()->is('home') ? 'bg-gray-700' : '' }}">
                            Home
                        </a>
                    </li>
                    <li>
                        <a href="/" class="block p-2 rounded hover:bg-gray-700 {{ request()->is('/') ? 'bg-gray-700' : '' }}">
                            Kriteria
                        </a>
                    </li>
                    <li>
                        <a href="/alternative" class="block p-2 rounded hover:bg-gray-700 {{ request()->is('alternative') ? 'bg-gray-700' : '' }}">
                            Alternatif
                        </a>
                    </li>
                    <li>
                        <a href="/evaluation" class="block p-2 rounded hover:bg-gray-700 {{ request()->is('evaluation') ? 'bg-gray-700' : '' }}">
                            Evaluasi
                        </a>
                    </li>
                    <li>
                        <a href="/calculate" class="block p-2 rounded hover:bg-gray-700 {{ request()->is('calculate') ? 'bg-gray-700' : '' }}">
                            Hasil Perhitungan
                        </a>
                    </li>
                </ul>
            </div>
        </aside>
    @endauth

    <main class="@auth flex-1 ml-64 p-6 overflow-auto text-white min-h-screen @else w-full @endauth">
        {{ $slot }}
    </main>

    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
</body>

</html>
