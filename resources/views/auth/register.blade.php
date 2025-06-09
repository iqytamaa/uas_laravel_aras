    <!DOCTYPE html>
    <html lang="en">
    <head>
        <meta charset="UTF-8" />
        <meta name="viewport" content="width=device-width, initial-scale=1" />
        <title>Register - Metode ARAS</title>
        <link href="{{ asset('css/app.css') }}" rel="stylesheet" />
        <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css" rel="stylesheet">
        <style>
            .input-icon {
                position: absolute;
                top: 50%;
                right: 0.75rem;
                transform: translateY(-50%);
                cursor: pointer;
                color: #6b7280; /* Tailwind gray-500 */
            }
            .input-with-icon {
                padding-right: 2.5rem; /* space for icon inside */
            }
        </style>
    </head>
    <body class="bg-gray-900 text-white flex items-center justify-center min-h-screen">

        <form action="{{ route('register.submit') }}" method="POST" class="bg-gray-800 p-8 rounded-lg shadow-lg w-full max-w-md">
            @csrf
            <h2 class="text-3xl font-bold mb-6 text-center">Register</h2>

            @if(session('success'))
                <div class="bg-green-600 p-2 rounded mb-4 text-center">
                    {{ session('success') }}
                </div>
            @endif

            @error('name')
                <div class="bg-red-600 p-2 rounded mb-4">{{ $message }}</div>
            @enderror
            <input type="text" name="name" placeholder="Masukkan nama lengkap" value="{{ old('name') }}" required
                class="w-full p-3 mb-4 rounded text-black focus:outline-none focus:ring-2 focus:ring-blue-500" />

            @error('email')
                <div class="bg-red-600 p-2 rounded mb-4">{{ $message }}</div>
            @enderror
            <input type="email" name="email" placeholder="contoh: user@email.com" value="{{ old('email') }}" required
                class="w-full p-3 mb-4 rounded text-black focus:outline-none focus:ring-2 focus:ring-blue-500" />

            @error('password')
                <div class="bg-red-600 p-2 rounded mb-4">{{ $message }}</div>
            @enderror

            <!-- Input Password -->
            <div class="relative mb-2">
                <input type="password" name="password" id="password"
                    placeholder="Minimal 8 karakter, huruf besar, angka & simbol"
                    required
                    class="w-full p-3 rounded text-black focus:outline-none focus:ring-2 focus:ring-blue-500 input-with-icon" />
                <span onclick="togglePassword()" class="input-icon">
                    <i id="eyeIcon" class="fas fa-eye"></i>
                </span>
            </div>

            <!-- Kriteria Password -->
            <ul class="text-sm text-gray-400 mb-4 ml-2">
                <li id="rule-length">• Minimal 8 karakter</li>
                <li id="rule-lowercase">• Huruf kecil (a-z)</li>
                <li id="rule-uppercase">• Huruf besar (A-Z)</li>
                <li id="rule-number">• Angka (0-9)</li>
                <li id="rule-symbol">• Simbol (!@#$%^&*)</li>
            </ul>

            <!-- Konfirmasi Password -->
            <div class="relative mb-6">
                <input type="password" name="password_confirmation" id="password_confirmation"
                    placeholder="Ulangi password"
                    required
                    class="w-full p-3 rounded text-black focus:outline-none focus:ring-2 focus:ring-blue-500 input-with-icon" />
                <span onclick="toggleConfirmPassword()" class="input-icon">
                    <i id="eyeConfirmIcon" class="fas fa-eye"></i>
                </span>
            </div>

            <button type="submit" class="w-full bg-blue-600 py-3 rounded hover:bg-blue-700 transition">
                Register
            </button>

            <p class="mt-6 text-center text-gray-400">
                Sudah punya akun? <a href="{{ route('login') }}" class="text-blue-400 hover:underline">Login di sini</a>
            </p>
        </form>

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

            function toggleConfirmPassword() {
                const input = document.getElementById('password_confirmation');
                const icon = document.getElementById('eyeConfirmIcon');
                if (input.type === 'password') {
                    input.type = 'text';
                    icon.classList.replace('fa-eye', 'fa-eye-slash');
                } else {
                    input.type = 'password';
                    icon.classList.replace('fa-eye-slash', 'fa-eye');
                }
            }
        </script>

    </body>
    </html>
