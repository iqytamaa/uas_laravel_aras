<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1" />
  <title>Login - Metode ARAS</title>
  <link href="{{ asset('css/app.css') }}" rel="stylesheet" />
  <script src="https://www.google.com/recaptcha/api.js" async defer></script>
  <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css" rel="stylesheet">
  <style>
    .input-icon {
      position: absolute;
      top: 50%;
      right: 0.75rem;
      transform: translateY(-50%);
      cursor: pointer;
      color: #6b7280;
    }
    .input-with-icon {
      padding-right: 2.5rem;
    }
  </style>
</head>
<body class="bg-gray-900 text-white flex items-center justify-center min-h-screen">

  <form action="{{ route('login.submit') }}" method="POST" class="bg-gray-800 p-8 rounded-lg shadow-lg w-full max-w-md">
    @csrf
    <h2 class="text-3xl font-bold mb-6 text-center">Login</h2>

    @if(session('success'))
      <div class="bg-green-600 p-2 rounded mb-4 text-center">
        {{ session('success') }}
      </div>
    @endif

    @error('email')
      <div class="bg-red-600 p-2 rounded mb-4">{{ $message }}</div>
    @enderror

    @error('g-recaptcha-response')
      <div class="bg-red-600 p-2 rounded mb-4">{{ $message }}</div>
    @enderror

    <input type="email" name="email" id="email" value="{{ old('email') }}" required autofocus
      class="w-full p-3 rounded mb-4 text-black focus:outline-none focus:ring-2 focus:ring-blue-500"
      placeholder="contoh: user@email.com">

    <!-- Input password + icon -->
    <div class="relative mb-2">
      <input type="password" name="password" id="password"
        class="w-full p-3 rounded text-black input-with-icon focus:outline-none focus:ring-2 focus:ring-blue-500"
        placeholder="Minimal 8 karakter, huruf besar, angka & simbol" required>
      <span onclick="togglePassword()" class="input-icon">
        <i id="eyeIcon" class="fas fa-eye"></i>
      </span>
    </div>

    <!-- Kriteria password -->
    <ul class="text-sm text-gray-400 mb-4 ml-2">
      <li id="rule-length">• Minimal 8 karakter</li>
      <li id="rule-lowercase">• Huruf kecil (a-z)</li>
      <li id="rule-uppercase">• Huruf besar (A-Z)</li>
      <li id="rule-number">• Angka (0-9)</li>
      <li id="rule-symbol">• Simbol (!@#$%^&*)</li>
    </ul>

    <div class="flex items-center mb-4">
      <input type="checkbox" name="remember" id="remember" class="mr-2">
      <label for="remember" class="text-sm text-gray-300">Ingat saya</label>
    </div>

    <!-- reCAPTCHA -->
    <div class="g-recaptcha mb-4" data-sitekey="{{ env('RECAPTCHA_SITE_KEY') }}"></div>

    <!-- Tombol login -->
    <button type="submit" id="loginButton"
      class="w-full bg-blue-600 py-3 rounded hover:bg-blue-700 transition flex items-center justify-center gap-2">
      <span id="btnText">Login</span>
      <svg id="loadingSpinner" class="hidden animate-spin h-5 w-5 text-white" xmlns="http://www.w3.org/2000/svg"
        fill="none" viewBox="0 0 24 24">
        <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
        <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8v8z"></path>
      </svg>
    </button>

    <!-- Tombol login Google -->
    <div class="mt-4">
      <a href="{{ url('/login/google') }}"
        class="w-full inline-block bg-red-600 py-3 rounded text-center hover:bg-red-700 transition">
        <i class="fab fa-google mr-2"></i> Login dengan Google
      </a>
    </div>

    <p class="mt-6 text-center text-gray-400">
      Belum punya akun? <a href="{{ route('register') }}" class="text-blue-400 hover:underline">Register di sini</a>
    </p>
  </form>

  <!-- JS: Validasi password -->
  <script>
    document.addEventListener("DOMContentLoaded", function () {
      const passwordInput = document.getElementById('password');
      const rules = {
        length: document.getElementById('rule-length'),
        lowercase: document.getElementById('rule-lowercase'),
        uppercase: document.getElementById('rule-uppercase'),
        number: document.getElementById('rule-number'),
        symbol: document.getElementById('rule-symbol')
      };

      passwordInput.addEventListener('input', function () {
        const value = passwordInput.value;
        rules.length.style.color = value.length >= 8 ? 'lightgreen' : 'gray';
        rules.lowercase.style.color = /[a-z]/.test(value) ? 'lightgreen' : 'gray';
        rules.uppercase.style.color = /[A-Z]/.test(value) ? 'lightgreen' : 'gray';
        rules.number.style.color = /[0-9]/.test(value) ? 'lightgreen' : 'gray';
        rules.symbol.style.color = /[!@#$%^&*]/.test(value) ? 'lightgreen' : 'gray';
      });
    });
  </script>

  <!-- JS: Toggle show/hide password -->
  <script>
    function togglePassword() {
      const input = document.getElementById('password');
      const icon = document.getElementById('eyeIcon');
      if (input.type === 'password') {
        input.type = 'text';
        icon.classList.replace('fa-eye', 'fa-eye-slash');
      } else {
        input.type = 'password';
        icon.classList.replace('fa-eye-slash', 'fa-eye');
      }
    }
  </script>

  <!-- JS: Loading spinner on submit -->
  <script>
    document.querySelector('form').addEventListener('submit', function () {
      const btn = document.getElementById('loginButton');
      document.getElementById('btnText').innerText = 'Memproses...';
      document.getElementById('loadingSpinner').classList.remove('hidden');
      btn.disabled = true;
    });
  </script>

</body>
</html>
