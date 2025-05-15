<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>{{ $title ?? 'ARAS SPK' }}</title>
  @vite('resources/css/app.css')
</head>
<body class="bg-gray-100 text-gray-900 min-h-screen flex flex-col">

  {{-- Top Navigation untuk User --}}
  <nav class="bg-blue-600 text-white p-4 flex space-x-6">
    <a href="{{ route('user.home') }}"
       class="hover:underline {{ request()->routeIs('user.home') ? 'font-bold' : '' }}">
      Home
    </a>
    <a href="{{ route('user.criteria.index') }}"
       class="hover:underline {{ request()->routeIs('user.criteria.*') ? 'font-bold' : '' }}">
      Kriteria
    </a>
    <a href="{{ route('user.alternatives.index') }}"
       class="hover:underline {{ request()->routeIs('user.alternatives.*') ? 'font-bold' : '' }}">
      Alternatif
    </a>
    <a href="{{ route('user.evaluation.index') }}"
       class="hover:underline {{ request()->routeIs('user.evaluation.*') ? 'font-bold' : '' }}">
      Evaluasi
    </a>
    <a href="{{ route('user.results.index') }}"
       class="hover:underline {{ request()->routeIs('user.results.*') ? 'font-bold' : '' }}">
      Hasil
    </a>

    {{-- Spacer --}}
    <div class="flex-1"></div>

    {{-- Tombol Admin atau Login --}}
    @auth
      <a href="{{ route('home') }}"
         class="bg-white text-blue-600 px-3 py-1 rounded hover:bg-gray-200">
        Admin
      </a>
    @else
      <a href="{{ route('login') }}"
         class="bg-white text-blue-600 px-3 py-1 rounded hover:bg-gray-200">
        Login
      </a>
    @endauth
  </nav>

  {{-- Konten User --}}
  <main class="flex-1 p-6">
    @yield('content')
  </main>

  @vite('resources/js/app.js')
</body>
</html>
