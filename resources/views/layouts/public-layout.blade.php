{{-- resources/views/components/public-layout.blade.php --}}
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1" />
  <title>{{ $title ?? 'ARAS SPK' }}</title>
  @vite('resources/css/app.css')
</head>
<body class="bg-gray-900 text-white flex flex-col min-h-screen">

  {{-- Topnav Public --}}
  <header class="bg-gray-800 shadow">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 flex items-center h-16 justify-between">
      {{-- Brand --}}
      <a href="{{ url('/user') }}" class="text-xl font-bold">ARAS SPK</a>

      {{-- Simplified nav: only Home/User/Admin --}}
      <nav class="flex space-x-4">
        <a href="{{ url('/user') }}"
           class="hover:underline {{ request()->is('user') ? 'underline' : '' }}">
          Home
        </a>
        <a href="{{ url('/user/criteria') }}"
           class="hover:underline {{ request()->is('user/criteria') ? 'underline' : '' }}">
          Kriteria
        </a>
        <a href="{{ url('/user/alternatives') }}"
           class="hover:underline {{ request()->is('user/alternatives') ? 'underline' : '' }}">
          Alternatif
        </a>
        <a href="{{ url('/user/evaluation') }}"
           class="hover:underline {{ request()->is('user/evaluation') ? 'underline' : '' }}">
          Evaluasi
        </a>
        <a href="{{ url('/user/results') }}"
           class="hover:underline {{ request()->is('user/results') ? 'underline' : '' }}">
          Hasil
        </a>
      </nav>

      {{-- Login / Dashboard --}}
      <div>
        @auth
          <a href="{{ route('home') }}"
             class="bg-blue-600 hover:bg-blue-700 px-3 py-1 rounded">
            Admin
          </a>
        @else
          <a href="{{ route('login') }}"
             class="bg-blue-600 hover:bg-blue-700 px-3 py-1 rounded">
            Login
          </a>
        @endauth
      </div>
    </div>
  </header>

  {{-- Content --}}
  <main class="flex-1 overflow-auto p-6">
    {{ $slot }}
  </main>

  <footer class="bg-gray-800 text-center text-gray-400 p-4">
    &copy; {{ date('Y') }} ARAS SPK
  </footer>
</body>
</html>
