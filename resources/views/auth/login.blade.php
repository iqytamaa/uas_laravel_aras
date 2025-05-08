<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <title>Login - Metode ARAS</title>
    <link href="{{ asset('css/app.css') }}" rel="stylesheet" />
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

        <label for="email" class="block mb-1">Email</label>
        <input type="email" name="email" id="email" value="{{ old('email') }}" required autofocus
            class="w-full p-3 rounded mb-4 text-black focus:outline-none focus:ring-2 focus:ring-blue-500" placeholder="Email">

        <label for="password" class="block mb-1">Password</label>
        <input type="password" name="password" id="password" required
            class="w-full p-3 rounded mb-6 text-black focus:outline-none focus:ring-2 focus:ring-blue-500" placeholder="Password">

        <button type="submit" class="w-full bg-blue-600 py-3 rounded hover:bg-blue-700 transition">
            Login
        </button>

        <p class="mt-6 text-center text-gray-400">
            Belum punya akun? <a href="{{ route('register') }}" class="text-blue-400 hover:underline">Register di sini</a>
        </p>
    </form>

</body>
</html>
