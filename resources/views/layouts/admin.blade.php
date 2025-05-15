<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>{{ $title ?? 'Admin • ARAS SPK' }}</title>
  @vite('resources/css/app.css')
</head>
<body class="flex h-screen bg-gray-900 text-gray-200 overflow-hidden">

  {{-- Sidebar Admin --}}
  <aside class="w-64 bg-gray-800 p-6 flex-shrink-0">
    <h1 class="text-white text-2xl font-bold mb-8">ARAS SPK</h1>
    <nav class="space-y-4">
      <a href="{{ route('home') }}"
         class="flex items-center px-4 py-2 rounded-lg hover:bg-gray-700 {{ request()->routeIs('home') ? 'bg-gray-700' : '' }}">
        Home
      </a>

      <a href="{{ route('criteria.index') }}"
         class="flex items-center px-4 py-2 rounded-lg hover:bg-gray-700 {{ request()->routeIs('criteria.*') ? 'bg-gray-700' : '' }}">
        Kriteria
      </a>

      <a href="{{ route('alternatives.index') }}"
         class="flex items-center px-4 py-2 rounded-lg hover:bg-gray-700 {{ request()->routeIs('alternatives.*') ? 'bg-gray-700' : '' }}">
        Alternatif
      </a>

      <a href="{{ route('evaluation.index') }}"
         class="flex items-center px-4 py-2 rounded-lg hover:bg-gray-700 {{ request()->routeIs('evaluation.*') ? 'bg-gray-700' : '' }}">
        Evaluasi
      </a>

      <a href="{{ route('dss.calculate') }}"
         class="flex items-center px-4 py-2 rounded-lg hover:bg-gray-700 {{ request()->routeIs('dss.calculate') ? 'bg-gray-700' : '' }}">
        Hasil
      </a>

      <form action="{{ route('logout') }}" method="POST" class="mt-6">
        @csrf
        <button type="submit"
                class="w-full text-left px-4 py-2 rounded-lg hover:bg-gray-700">
          Logout
        </button>
      </form>
    </nav>
  </aside>

  {{-- Konten Admin --}}
  <main class="flex-1 overflow-auto p-6">
    @yield('content')
  </main>

  @vite('resources/js/app.js')
</body>
</html>
