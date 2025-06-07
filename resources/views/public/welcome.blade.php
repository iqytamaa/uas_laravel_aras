<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Selamat Datang di Aplikasi ARAS SPK</title>
    @vite('resources/css/app.css')
</head>

<body class="bg-gray-50 min-h-screen">
    <!-- Navigation -->
    <nav class="bg-blue-600 text-white shadow-md">
        <div class="max-w-6xl mx-auto px-4">
            <div class="flex justify-between items-center h-16">
                <div class="flex items-center">
                    <div class="flex-shrink-0">
                        <span class="text-xl font-bold">ARAS SPK</span>
                    </div>
                </div>
                <div>
                </div>
            </div>
        </div>
    </nav>

    <!-- Hero Section -->
    <div class="max-w-6xl mx-auto px-4 py-12 md:py-24">
        <div class="grid grid-cols-1 md:grid-cols-2 gap-8 items-center">
            <div>
                <h1 class="text-4xl font-bold text-gray-800 mb-4">Selamat Datang di Aplikasi ARAS SPK!</h1>
                <p class="text-lg text-gray-600 mb-8">
                    Aplikasi Sistem Pendukung Keputusan menggunakan metode ARAS (Additive Ratio Assessment) untuk
                    membantu Anda membuat keputusan yang lebih baik.
                </p>
                <p class="text-gray-600 mb-6">
                    Lihat hasil perhitungan tanpa harus login.
                </p>
                <div class="flex flex-wrap gap-4">
                    <a href="{{ route('user.criteria.index') }}"
                        class="bg-blue-600 hover:bg-blue-700 text-white px-6 py-3 rounded-lg font-medium transition-colors flex items-center">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2" fill="none" viewBox="0 0 24 24"
                            stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2" />
                        </svg>
                        Lihat Kriteria
                    </a>
                    <a href="{{ route('user.alternatives.index') }}"
                        class="bg-white border border-blue-600 text-blue-600 hover:bg-blue-50 px-6 py-3 rounded-lg font-medium transition-colors flex items-center">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2" fill="none" viewBox="0 0 24 24"
                            stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M4 6h16M4 10h16M4 14h16M4 18h16" />
                        </svg>
                        Lihat Alternatif
                    </a>
                    <a href="{{ route('user.results.index') }}"
                        class="bg-white border border-green-600 text-green-600 hover:bg-green-50 px-6 py-3 rounded-lg font-medium transition-colors flex items-center">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2" fill="none" viewBox="0 0 24 24"
                            stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z" />
                        </svg>
                        Lihat Hasil
                    </a>
                </div>
            </div>
            <div class="hidden md:block">
                <div class="bg-white p-6 rounded-lg shadow-lg border border-gray-200">
                    <div class="flex items-center justify-center mb-6">
                        <div class="bg-blue-100 p-3 rounded-full">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-12 w-12 text-blue-600" fill="none"
                                viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M9 7h6m0 10v-3m-3 3h.01M9 17h.01M9 14h.01M12 14h.01M15 11h.01M12 11h.01M9 11h.01M7 21h10a2 2 0 002-2V5a2 2 0 00-2-2H7a2 2 0 00-2 2v14a2 2 0 002 2z" />
                            </svg>
                        </div>
                    </div>
                    <h3 class="text-xl font-semibold text-gray-800 mb-4 text-center">Tentang Metode ARAS</h3>
                    <p class="text-gray-600 text-sm mb-4">
                        ARAS (Additive Ratio Assessment) adalah metode pengambilan keputusan multi-kriteria yang
                        membandingkan
                        nilai utilitas alternatif dengan nilai utilitas alternatif ideal.
                    </p>
                    <div class="grid grid-cols-1 gap-3">
                        <div class="bg-gray-50 p-3 rounded-lg">
                            <div class="flex items-start">
                                <div
                                    class="flex-shrink-0 h-8 w-8 rounded-full bg-blue-100 flex items-center justify-center mr-3">
                                    <span class="text-blue-600 font-bold">1</span>
                                </div>
                                <div>
                                    <p class="text-sm font-medium text-gray-900">Matriks Keputusan</p>
                                    <p class="text-xs text-gray-500">Membentuk matriks keputusan dengan nilai alternatif
                                        untuk setiap kriteria.</p>
                                </div>
                            </div>
                        </div>
                        <div class="bg-gray-50 p-3 rounded-lg">
                            <div class="flex items-start">
                                <div
                                    class="flex-shrink-0 h-8 w-8 rounded-full bg-blue-100 flex items-center justify-center mr-3">
                                    <span class="text-blue-600 font-bold">2</span>
                                </div>
                                <div>
                                    <p class="text-sm font-medium text-gray-900">Normalisasi</p>
                                    <p class="text-xs text-gray-500">Menormalisasi nilai-nilai dalam matriks keputusan.
                                    </p>
                                </div>
                            </div>
                        </div>
                        <div class="bg-gray-50 p-3 rounded-lg">
                            <div class="flex items-start">
                                <div
                                    class="flex-shrink-0 h-8 w-8 rounded-full bg-blue-100 flex items-center justify-center mr-3">
                                    <span class="text-blue-600 font-bold">3</span>
                                </div>
                                <div>
                                    <p class="text-sm font-medium text-gray-900">Pembobotan</p>
                                    <p class="text-xs text-gray-500">Mengalikan nilai ternormalisasi dengan bobot
                                        kriteria.</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Features Section -->
    <div class="bg-gray-100 py-12">
        <div class="max-w-6xl mx-auto px-4">
            <h2 class="text-2xl font-bold text-gray-800 mb-8 text-center">Fitur Aplikasi</h2>
            <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                <div class="bg-white p-6 rounded-lg shadow-md">
                    <div class="w-12 h-12 rounded-full bg-blue-100 flex items-center justify-center mb-4">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-blue-600" fill="none"
                            viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2" />
                        </svg>
                    </div>
                    <h3 class="text-lg font-semibold text-gray-800 mb-2">Manajemen Kriteria</h3>
                    <p class="text-gray-600 text-sm">
                        Tentukan kriteria yang akan digunakan dalam pengambilan keputusan beserta bobot untuk
                        masing-masing kriteria.
                    </p>
                </div>
                <div class="bg-white p-6 rounded-lg shadow-md">
                    <div class="w-12 h-12 rounded-full bg-blue-100 flex items-center justify-center mb-4">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-blue-600" fill="none"
                            viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M4 6h16M4 10h16M4 14h16M4 18h16" />
                        </svg>
                    </div>
                    <h3 class="text-lg font-semibold text-gray-800 mb-2">Manajemen Alternatif</h3>
                    <p class="text-gray-600 text-sm">
                        Kelola alternatif yang akan dievaluasi dan berikan nilai untuk setiap alternatif berdasarkan
                        kriteria.
                    </p>
                </div>
                <div class="bg-white p-6 rounded-lg shadow-md">
                    <div class="w-12 h-12 rounded-full bg-blue-100 flex items-center justify-center mb-4">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-blue-600" fill="none"
                            viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z" />
                        </svg>
                    </div>
                    <h3 class="text-lg font-semibold text-gray-800 mb-2">Hasil Perhitungan</h3>
                    <p class="text-gray-600 text-sm">
                        Lihat hasil perhitungan ARAS dengan visualisasi yang jelas dan mudah dipahami.
                    </p>
                </div>
            </div>
        </div>
    </div>

    <!-- Evaluation Section -->
    <div class="py-12">
        <div class="max-w-6xl mx-auto px-4">
            <div class="bg-blue-600 text-white rounded-lg shadow-lg p-6 md:p-8">
                <div class="flex flex-col md:flex-row items-center">
                    <div class="md:w-2/3 mb-6 md:mb-0 md:pr-8">
                        <h2 class="text-2xl font-bold mb-4">Evaluasi Alternatif</h2>
                        <p class="mb-4">
                            Ingin melakukan evaluasi alternatif berdasarkan kriteria yang telah ditentukan?
                            Anda dapat melakukannya tanpa perlu login.
                        </p>
                        <a href="{{ route('user.evaluation.index') }}"
                            class="inline-block bg-white text-blue-600 hover:bg-blue-50 px-6 py-3 rounded-lg font-medium transition-colors">
                            Mulai Evaluasi
                        </a>
                    </div>
                    <div class="md:w-1/3">
                        <div class="bg-white/10 p-6 rounded-lg">
                            <div class="flex items-center mb-4">
                                <div class="w-10 h-10 rounded-full bg-white/20 flex items-center justify-center mr-3">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-white" fill="none"
                                        viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" />
                                    </svg>
                                </div>
                                <h3 class="text-lg font-medium">Evaluasi Cepat</h3>
                            </div>
                            <ul class="space-y-2 text-sm">
                                <li class="flex items-start">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2 flex-shrink-0"
                                        fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M5 13l4 4L19 7" />
                                    </svg>
                                    <span>Tanpa perlu login</span>
                                </li>
                                <li class="flex items-start">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2 flex-shrink-0"
                                        fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M5 13l4 4L19 7" />
                                    </svg>
                                    <span>Mudah dan cepat</span>
                                </li>
                                <li class="flex items-start">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2 flex-shrink-0"
                                        fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M5 13l4 4L19 7" />
                                    </svg>
                                    <span>Hasil langsung tersedia</span>
                                </li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Footer -->
    <footer class="bg-white py-6 border-t border-gray-200">
        <div class="max-w-6xl mx-auto px-4">
            <div class="flex flex-col md:flex-row justify-between items-center">
                <div class="mb-4 md:mb-0">
                    <p class="text-gray-600 text-sm">&copy; {{ date('Y') }} Aplikasi ARAS SPK. All rights reserved.</p>
                </div>
                <div class="flex space-x-4">
                    <a href="#" class="text-gray-500 hover:text-blue-600">
                        <span class="sr-only">Tentang</span>
                        <span class="text-sm">Tentang</span>
                    </a>
                    <a href="#" class="text-gray-500 hover:text-blue-600">
                        <span class="sr-only">Bantuan</span>
                        <span class="text-sm">Bantuan</span>
                    </a>
                    <a href="#" class="text-gray-500 hover:text-blue-600">
                        <span class="sr-only">Kontak</span>
                        <span class="text-sm">Kontak</span>
                    </a>
                </div>
            </div>
        </div>
    </footer>
</body>

</html>