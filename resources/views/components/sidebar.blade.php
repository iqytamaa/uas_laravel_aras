{{-- resources/views/components/sidebar.blade.php --}}
<aside id="default-sidebar"
    class="fixed top-0 left-0 z-40 w-64 h-screen transition-transform -translate-x-full sm:translate-x-0"
    aria-label="Sidebar">
  <div class="h-full px-3 py-4 overflow-y-auto bg-gray-50 dark:bg-gray-800">
    <ul class="space-y-2 font-medium">

      <li>
        <div class="flex items-center font-bold bg-gray-900 text-gray-200 p-2 rounded-lg group">
          <span class="ms-3">Metode ARAS</span>
        </div>
      </li>

      <li>
        <a href="/home"
           class="flex items-center font-bold {{ request()->is('home') ? 'bg-gray-400 text-gray-900' : 'text-gray-200 bg-gray-800 hover:bg-gray-400 hover:text-gray-900' }} p-2 rounded-lg group">
          <svg class="w-5 h-5 text-gray-500 transition duration-75" fill="currentColor" viewBox="0 0 20 20">
            <path d="M10 2L2 8h3v8h4V12h2v4h4V8h3L10 2z" />
          </svg>
          <span class="ms-3">Home</span>
        </a>
      </li>

      <li>
        <a href="{{ url('/criteria') }}"
           class="flex items-center font-bold {{ request()->is('criteria*') ? 'bg-gray-400 text-gray-900' : 'text-gray-200 bg-gray-800 hover:bg-gray-400 hover:text-gray-900' }} p-2 rounded-lg group">
          <svg class="w-5 h-5 text-gray-500 transition duration-75" fill="currentColor" viewBox="0 0 20 20">
            <path d="M3 5h14v2H3V5zM3 9h14v6H3V9z" />
          </svg>
          <span class="ms-3">Kriteria</span>
        </a>
      </li>

      <li>
        <a href="{{ route('alternatives.index') }}"
           class="flex items-center font-bold {{ request()->routeIs('alternatives.*') ? 'bg-gray-400 text-gray-900' : 'text-gray-200 bg-gray-800 hover:bg-gray-400 hover:text-gray-900' }} p-2 rounded-lg group">
          <!-- Ikon diganti jadi circle slice -->
          <svg class="w-5 h-5 text-gray-500 transition duration-75" fill="currentColor" viewBox="0 0 20 20">
            <path fill-rule="evenodd"
                  d="M10 18a8 8 0 100-16 8 8 0 000 16zm1-8V4a6 6 0 016 6h-6z"
                  clip-rule="evenodd"/>
          </svg>
          <span class="ms-3">Alternatif</span>
        </a>
      </li>

      <li>
        <a href="/evaluation"
           class="flex items-center font-bold {{ request()->is('evaluation') ? 'bg-gray-400 text-gray-900' : 'text-gray-200 bg-gray-800 hover:bg-gray-400 hover:text-gray-900' }} p-2 rounded-lg group">
          <svg class="w-5 h-5 text-gray-500 transition duration-75" fill="currentColor" viewBox="0 0 20 20">
            <path d="M5 3h10a1 1 0 011 1v12a1 1 0 01-1 1H5a1 1 0 01-1-1V4a1 1 0 011-1z" />
          </svg>
          <span class="ms-3">Evaluasi</span>
        </a>
      </li>

      <li>
        <a href="/calculate"
           class="flex items-center font-bold {{ request()->is('calculate') ? 'bg-gray-400 text-gray-900' : 'text-gray-200 bg-gray-800 hover:bg-gray-400 hover:text-gray-900' }} p-2 rounded-lg group">
          <svg class="w-5 h-5 text-gray-500 transition duration-75" fill="currentColor" viewBox="0 0 20 20">
            <path d="M3 3h14v2H3V3zm0 4h14v2H3V7zm0 4h14v2H3v-2z" />
          </svg>
          <span class="ms-3">Hasil Perhitungan</span>
        </a>
      </li>

    </ul>
  </div>
</aside>

<div class="p-4 sm:ml-64">
  @if (session('success'))
    <div class="bg-green-600 text-white font-bold p-4 mb-4 rounded-xl">
      {{ session('success') }}
    </div>
  @endif

  @if ($errors->any())
    <div class="bg-red-500 text-white p-4 mb-4 rounded-xl">
      <ul>
        @foreach ($errors->all() as $error)
          <li>{{ $error }}</li>
        @endforeach
      </ul>
    </div>
  @endif

  {{ $slot }}
</div>
