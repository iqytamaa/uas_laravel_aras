<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1" />
  <title>ARAS</title>
  @vite('resources/css/app.css')
</head>
<body class="bg-gray-900 text-white flex flex-col h-screen">

  {{-- Top Navbar --}}
  <header class="bg-gray-800 shadow">
    <div class="max-w-7xl mx-auto flex justify-between items-center h-16 px-4">
      {{-- Brand --}}
      <a href="{{ auth()->check() ? route('home') : url('/user') }}"
         class="text-xl font-bold">
        ARAS SPK
      </a>

      {{-- Simplified nav: only Admin & User --}}
      <nav class="space-x-4">
        @auth
          <a href="{{ route('home') }}"
             class="px-3 py-1 hover:underline {{ request()->routeIs('home') ? 'underline' : '' }}">
            Admin
          </a>
        @endauth

        <a href="{{ url('/user') }}"
           class="px-3 py-1 hover:underline {{ request()->is('user*') ? 'underline' : '' }}">
          User
        </a>
      </nav>

      {{-- Logout or Login --}}
      <div>
        @auth
          <form method="POST" action="{{ route('logout') }}" class="inline">
            @csrf
            <button type="submit"
                    class="bg-red-600 hover:bg-red-700 px-3 py-1 rounded">
              Logout
            </button>
          </form>
        @else
          <a href="{{ route('login') }}"
             class="bg-blue-600 hover:bg-blue-700 px-3 py-1 rounded">
            Login
          </a>
        @endauth
      </div>
    </div>
  </header>

  <div class="flex flex-1 overflow-hidden">
    @auth
      {{-- Sidebar for Admin --}}
      <aside class="w-64 bg-gray-900 p-4 space-y-2">
        <a href="{{ route('home') }}"
           class="block px-2 py-1 rounded {{ request()->routeIs('home') ? 'bg-gray-700' : 'hover:bg-gray-800' }}">
          Home
        </a>
        {{-- tambahkan link admin lain di sini jika perlu --}}
      </aside>
    @endauth

    {{-- Main Content --}}
    <main class="flex-1 overflow-auto p-6">
      {{ $slot }}
    </main>
  </div>

</body>
</html>
