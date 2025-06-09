{{-- resources/views/components/layout.blade.php --}}
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1" />
  <title>{{ $title ?? '' }}</title>

  {{-- Import Tailwind CSS via Vite --}}
  @vite('resources/css/app.css')

  {{-- SweetAlert2 CDN --}}
  <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
</head>
<body class="bg-gray-900 text-white flex flex-col min-h-screen">

  {{-- Navbar --}}
<header class="bg-gray-800 shadow">
  <div class="max-w-7xl mx-auto flex justify-end items-center h-16 px-6">
    @auth
      {{-- Tombol Logout --}}
      <form method="POST" action="{{ route('logout') }}" id="logoutForm" class="inline mr-4">
        @csrf
        <button type="button" onclick="confirmLogout()" 
                class="px-4 py-2 bg-red-600 hover:bg-red-700 rounded-lg transition whitespace-nowrap">
          Logout
        </button>
      </form>

      {{-- Tombol Publik --}}
      <a href="{{ url('/user') }}"
         class="px-4 py-2 bg-green-600 hover:bg-green-700 text-white rounded-lg transition whitespace-nowrap">
        Publik
      </a>
    @endauth
  </div>
</header>



  {{-- Main content --}}
  <main class="flex-1 overflow-auto p-6">
    {{ $slot }}
  </main>

  <script>
    function confirmLogout() {
      Swal.fire({
        title: 'Yakin ingin logout?',
        text: "Sesi Anda akan diakhiri.",
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#d33',
        cancelButtonColor: '#3085d6',
        confirmButtonText: 'Ya, logout!',
        cancelButtonText: 'Batal'
      }).then((result) => {
        if (result.isConfirmed) {
          document.getElementById('logoutForm').submit();
        }
      });
    }
  </script>

</body>
</html>
