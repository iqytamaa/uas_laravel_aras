{{-- resources/views/public/welcome.blade.php --}}
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Selamat Datang</title>
  @vite('resources/css/app.css')
</head>
<body class="bg-gray-900 text-white min-h-screen flex items-center justify-center">
  <div class="text-center">
    <h1 class="text-4xl font-bold mb-4">Selamat Datang di Aplikasi ARAS SPK!</h1>
    <p class="mb-6">Lihat hasil perhitungan tanpa harus login.</p>
    <a href="{{ route('user.criteria.index') }}"
       class="bg-blue-600 hover:bg-blue-700 px-4 py-2 rounded">
      Lihat Kriteria
    </a>
  </div>
</body>
</html>
