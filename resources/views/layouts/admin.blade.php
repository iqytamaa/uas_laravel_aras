{{-- resources/views/layouts/admin.blade.php --}}
@vite('resources/js/app.js')

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Dashboard Admin ARAS</title>
  <link href="{{ asset('css/app.css') }}" rel="stylesheet">
</head>
<body class="bg-gray-900 text-gray-200">

  <div class="flex">
    {{-- Sidebar --}}
    <aside class="w-64 bg-gray-800 p-6 space-y-4">
      <a href="{{ route('home') }}" 
         class="block hover:text-white">Home</a>
      <a href="{{ route('criteria.index') }}" 
         class="block hover:text-white">Kriteria</a>
      <a href="{{ route('alternatives.index') }}" 
         class="block hover:text-white">Alternatif</a>
      <a href="{{ route('evaluation.index') }}" 
         class="block hover:text-white">Evaluasi</a>
      <a href="{{ route('calculate') }}" 
         class="block font-bold text-blue-400">Hasil Perhitungan</a>
    </aside>

    {{-- Konten Utama --}}
    <main class="flex-1 p-8">
      @yield('content')
    </main>
  </div>

  @stack('scripts')
</body>
</html>
