        @extends('layouts.user')
        @section('title','Hasil Perhitungan')

        @section('content')
        <div class="max-w-6xl mx-auto px-4 py-8">
            <div class="flex justify-between items-center mb-6">
                <div>
                    <h1 class="text-3xl font-bold text-gray-800">Hasil Perhitungan ARAS</h1>
                    <p class="text-gray-600 mt-1">Peringkat alternatif berdasarkan metode ARAS</p>
                </div>
                
                <div class="flex items-center space-x-3">
                    <button id="print-button" class="flex items-center text-sm bg-gray-100 hover:bg-gray-200 text-gray-700 py-2 px-3 rounded-lg transition-colors">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-1" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 17h2a2 2 0 002-2v-4a2 2 0 00-2-2H5a2 2 0 00-2 2v4a2 2 0 002 2h2m2 4h6a2 2 0 002-2v-4a2 2 0 00-2-2H9a2 2 0 00-2 2v4a2 2 0 002 2zm8-12V5a2 2 0 00-2-2H9a2 2 0 00-2 2v4h10z" />
                        </svg>
                        Cetak
                    </button>
                    
                    <button id="export-button" class="flex items-center text-sm bg-blue-600 hover:bg-blue-700 text-white py-2 px-3 rounded-lg transition-colors">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-1" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4" />
                        </svg>
                        Export CSV
                    </button>
                </div>
            </div>

            @if($message ?? null)
                @php
                    // Determine error type based on message content or controller data
                    $errorType = $errorType ?? 'general';
                    
                    // Check message content to auto-detect error type if not provided
                    if (stripos($message, 'kriteria') !== false) {
                        $errorType = 'criteria';
                    } elseif (stripos($message, 'alternatif') !== false) {
                        $errorType = 'alternatives';
                    } elseif (stripos($message, 'data') !== false || stripos($message, 'validasi') !== false) {
                        $errorType = 'validation';
                    }
                    
                    $errorConfigs = [
                        'criteria' => [
                            'title' => 'Kriteria Belum Dikonfigurasi',
                            'description' => 'Admin belum mengatur kriteria penilaian yang diperlukan untuk perhitungan ARAS',
                            'icon' => 'M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z M15 12a3 3 0 11-6 0 3 3 0 016 0z',
                            'color' => 'orange',
                            'steps' => [
                                'Hubungi administrator untuk mengatur kriteria penilaian',
                                'Pastikan setiap kriteria memiliki bobot yang valid',
                                'Verifikasi jenis kriteria (benefit/cost) sudah benar',
                                'Total bobot semua kriteria harus sama dengan 1.0'
                            ]
                        ],
                        'alternatives' => [
                            'title' => 'Alternatif Belum Tersedia',
                            'description' => 'Tidak ada alternatif yang tersedia untuk dievaluasi atau data alternatif tidak lengkap',
                            'icon' => 'M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z M6 18L18 6M6 6l12 12',
                            'color' => 'blue',
                            'steps' => [
                                'Tambahkan minimal 2 alternatif untuk perbandingan',
                                'Pastikan semua alternatif memiliki nilai untuk setiap kriteria',
                                'Periksa kelengkapan data evaluasi alternatif',
                                'Verifikasi format data numerik sudah benar'
                            ]
                        ],
                        'validation' => [
                            'title' => 'Data Tidak Valid',
                            'description' => 'Terdapat data yang tidak sesuai format atau persyaratan sistem',
                            'icon' => 'M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-2.5L13.732 4c-.77-.833-1.964-.833-2.732 0L3.34 16.5c-.77.833.192 2.5 1.732 2.5z',
                            'color' => 'yellow',
                            'steps' => [
                                'Periksa format data yang diinput',
                                'Pastikan semua field wajib telah diisi',
                                'Verifikasi tipe data sesuai dengan yang diharapkan',
                                'Cek tidak ada nilai kosong atau negatif'
                            ]
                        ],
                        'general' => [
                            'title' => 'Terjadi Kesalahan',
                            'description' => 'Sistem tidak dapat menyelesaikan perhitungan dengan data yang tersedia',
                            'icon' => 'M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-2.5L13.732 4c-.77-.833-1.964-.833-2.732 0L3.34 16.5c-.77.833.192 2.5 1.732 2.5z',
                            'color' => 'red',
                            'steps' => [
                                'Periksa kelengkapan data kriteria dan alternatif',
                                'Hubungi administrator untuk bantuan',
                                'Coba refresh halaman dan ulangi proses',
                                'Pastikan semua data sudah tersimpan dengan benar'
                            ]
                        ]
                    ];
                    
                    $config = $errorConfigs[$errorType];
                @endphp

                <!-- Enhanced Error Information Card -->
                <div class="mb-8">
                    <div class="bg-white rounded-lg shadow-lg border-2 border-{{ $config['color'] }}-200 overflow-hidden">
                        <!-- Error Header -->
                        <div class="bg-{{ $config['color'] }}-50 px-6 py-6 border-b border-{{ $config['color'] }}-200">
                            <div class="flex items-center">
                                <div class="flex-shrink-0">
                                    <div class="w-12 h-12 bg-{{ $config['color'] }}-100 rounded-full flex items-center justify-center">
                                        <svg class="w-6 h-6 text-{{ $config['color'] }}-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="{{ $config['icon'] }}"></path>
                                        </svg>
                                    </div>
                                </div>
                                <div class="ml-4">
                                    <h3 class="text-lg font-medium text-gray-900">{{ $config['title'] }}</h3>
                                    <p class="text-sm text-gray-600 mt-1">{{ $config['description'] }}</p>
                                </div>
                            </div>
                        </div>

                        <!-- Error Content -->
                        <div class="px-6 py-6">
                            <!-- Error Message -->
                            <div class="bg-{{ $config['color'] }}-50 border border-{{ $config['color'] }}-200 rounded-lg p-4 mb-6">
                                <div class="flex">
                                    <div class="flex-shrink-0">
                                        <svg class="h-5 w-5 text-{{ $config['color'] }}-400" fill="currentColor" viewBox="0 0 20 20">
                                            <path fill-rule="evenodd" d="M8.257 3.099c.765-1.36 2.722-1.36 3.486 0l5.58 9.92c.75 1.334-.213 2.98-1.742 2.98H4.42c-1.53 0-2.493-1.646-1.743-2.98l5.58-9.92zM11 13a1 1 0 11-2 0 1 1 0 012 0zm-1-8a1 1 0 00-1 1v3a1 1 0 002 0V6a1 1 0 00-1-1z" clip-rule="evenodd" />
                                        </svg>
                                    </div>
                                    <div class="ml-3">
                                        <h4 class="text-sm font-medium text-{{ $config['color'] }}-800">Detail Kesalahan</h4>
                                        <div class="mt-2 text-sm text-{{ $config['color'] }}-700">
                                            <p>{{ $message }}</p>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <!-- Required Steps -->
                            <div class="mb-6">
                                <h4 class="text-sm font-medium text-gray-900 mb-3 flex items-center">
                                    <svg class="w-4 h-4 mr-2 text-{{ $config['color'] }}-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path>
                                    </svg>
                                    Langkah yang Diperlukan
                                </h4>
                                <div class="space-y-3">
                                    @foreach($config['steps'] as $index => $step)
                                        <div class="flex items-start">
                                            <div class="flex-shrink-0">
                                                <div class="w-6 h-6 bg-{{ $config['color'] }}-100 text-{{ $config['color'] }}-600 rounded-full flex items-center justify-center text-xs font-medium">
                                                    {{ $index + 1 }}
                                                </div>
                                            </div>
                                            <div class="ml-3">
                                                <p class="text-sm text-gray-700">{{ $step }}</p>
                                            </div>
                                        </div>
                                    @endforeach
                                </div>
                            </div>

                            <!-- Admin Contact Information -->
                            @if($errorType === 'criteria' || $errorType === 'alternatives')
                                <div class="bg-gray-50 rounded-lg p-4 mb-6">
                                    <div class="flex items-start">
                                        <div class="flex-shrink-0">
                                            <svg class="w-5 h-5 text-blue-500 mt-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                            </svg>
                                        </div>
                                        <div class="ml-3">
                                            <h4 class="text-sm font-medium text-gray-900">Informasi untuk Administrator</h4>
                                            <div class="mt-2 text-sm text-gray-600">
                                                @if($errorType === 'criteria')
                                                    <p>Sistem memerlukan konfigurasi kriteria sebelum dapat melakukan perhitungan ARAS. Silakan:</p>
                                                    <ul class="mt-2 list-disc list-inside space-y-1">
                                                        <li>Akses menu <strong>Kelola Kriteria</strong></li>
                                                        <li>Tambahkan minimal 2 kriteria penilaian</li>
                                                        <li>Tentukan bobot dan jenis setiap kriteria</li>
                                                        <li>Pastikan total bobot = 1.0</li>
                                                    </ul>
                                                @else
                                                    <p>Sistem memerlukan data alternatif sebelum dapat melakukan perhitungan. Silakan:</p>
                                                    <ul class="mt-2 list-disc list-inside space-y-1">
                                                        <li>Akses menu <strong>Kelola Alternatif</strong></li>
                                                        <li>Tambahkan minimal 2 alternatif</li>
                                                        <li>Lengkapi evaluasi untuk setiap kriteria</li>
                                                        <li>Pastikan semua data numerik valid</li>
                                                    </ul>
                                                @endif
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            @endif

                            <!-- Action Buttons -->
                            <div class="flex flex-col sm:flex-row gap-3 pt-4 border-t border-gray-200">
                                <button onclick="window.history.back()" class="flex items-center justify-center px-4 py-2 border border-gray-300 rounded-md shadow-sm text-sm font-medium text-gray-700 bg-white hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-{{ $config['color'] }}-500 flex-1">
                                    <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path>
                                    </svg>
                                    Kembali
                                </button>
                                
                                @if($errorType === 'criteria')
                                    <a href="{{ route('criteria.index') ?? '#' }}" class="flex items-center justify-center px-4 py-2 border border-transparent rounded-md shadow-sm text-sm font-medium text-white bg-{{ $config['color'] }}-600 hover:bg-{{ $config['color'] }}-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-{{ $config['color'] }}-500 flex-1">
                                        <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z"></path>
                                        </svg>
                                        Kelola Kriteria
                                    </a>
                                @elseif($errorType === 'alternatives')
                                    <a href="{{ route('alternatives.index') ?? '#' }}" class="flex items-center justify-center px-4 py-2 border border-transparent rounded-md shadow-sm text-sm font-medium text-white bg-{{ $config['color'] }}-600 hover:bg-{{ $config['color'] }}-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-{{ $config['color'] }}-500 flex-1">
                                        <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                                        </svg>
                                        Kelola Alternatif
                                    </a>
                                @else
                                    <button onclick="window.location.reload()" class="flex items-center justify-center px-4 py-2 border border-transparent rounded-md shadow-sm text-sm font-medium text-white bg-{{ $config['color'] }}-600 hover:bg-{{ $config['color'] }}-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-{{ $config['color'] }}-500 flex-1">
                                        <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15"></path>
                                        </svg>
                                        Coba Lagi
                                    </a>
                                @endif
                                
                                <a href="{{ route('dashboard') ?? '/' }}" class="flex items-center justify-center px-4 py-2 border border-gray-300 rounded-md shadow-sm text-sm font-medium text-gray-700 bg-white hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500 flex-1">
                                    <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"></path>
                                    </svg>
                                    Dashboard
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            @else
                <!-- Winner Card -->
                @if(isset($results) && count($results) > 0)
                    <div class="mb-8 bg-gradient-to-r from-blue-600 to-indigo-600 text-white rounded-lg shadow-lg">
                        <div class="p-6">
                            <div class="flex flex-col md:flex-row items-center justify-between">
                                <div class="flex items-center gap-4 mb-4 md:mb-0">
                                    <div class="bg-white/20 p-3 rounded-full">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-8 w-8" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                            <path d="M6 9H4.5a2.5 2.5 0 0 1 0-5H6"></path>
                                            <path d="M18 9h1.5a2.5 2.5 0 0 0 0-5H18"></path>
                                            <path d="M4 22h16"></path>
                                            <path d="M10 14.66V17c0 .55-.47.98-.97 1.21C7.85 18.75 7 20.24 7 22"></path>
                                            <path d="M14 14.66V17c0 .55.47.98.97 1.21C16.15 18.75 17 20.24 17 22"></path>
                                            <path d="M9 2v7.5"></path>
                                            <path d="M15 2v7.5"></path>
                                            <path d="M12 2v10"></path>
                                            <path d="M12 12a4 4 0 0 0 4-4V6H8v2a4 4 0 0 0 4 4Z"></path>
                                        </svg>
                                    </div>
                                    <div>
                                        <div class="text-white/70 text-sm">Alternatif Terbaik</div>
                                        <h2 class="text-2xl font-bold">{{ $results[0]['alternative_name'] }}</h2>
                                    </div>
                                </div>
                                <div class="text-center md:text-right">
                                    <div class="text-white/70 text-sm">Skor</div>
                                    <div class="text-4xl font-bold">{{ number_format($results[0]['score'] * 100, 2) }}%</div>
                                </div>
                            </div>
                        </div>
                    </div>
                @endif

                <!-- Results Visualization -->
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-8">
                    <!-- Bar Chart -->
                    <div class="bg-white rounded-lg shadow-md p-6">
                        <h3 class="text-lg font-medium text-gray-900 mb-4">Perbandingan Skor</h3>
                        
                        <!-- CSS-based fallback visualization for score comparison -->
                        <div class="mb-6">
                            @php
                                // Define an array of contrasting colors
                                $colors = [
                                    ['bg' => 'bg-blue-600', 'text' => 'text-white'],
                                    ['bg' => 'bg-purple-600', 'text' => 'text-white'],
                                    ['bg' => 'bg-green-600', 'text' => 'text-white'],
                                    ['bg' => 'bg-red-600', 'text' => 'text-white'],
                                    ['bg' => 'bg-yellow-500', 'text' => 'text-white'],
                                    ['bg' => 'bg-indigo-600', 'text' => 'text-white'],
                                    ['bg' => 'bg-pink-600', 'text' => 'text-white'],
                                    ['bg' => 'bg-teal-600', 'text' => 'text-white'],
                                    ['bg' => 'bg-orange-600', 'text' => 'text-white'],
                                    ['bg' => 'bg-cyan-600', 'text' => 'text-white'],
                                ];
                            @endphp
                            
                            @foreach($results as $i => $r)
                                <div class="mb-3">
                                    <div class="flex justify-between mb-1">
                                        <span class="text-sm font-medium text-gray-700">{{ $r['alternative_name'] }}</span>
                                        <span class="text-sm font-medium text-gray-700">{{ number_format($r['score'] * 100, 2) }}%</span>
                                    </div>
                                    <div class="w-full bg-gray-200 rounded-full h-6 flex items-center">
                                        <div class="{{ $colors[$i % count($colors)]['bg'] }} h-6 rounded-full px-3 flex items-center" style="width: {{ $r['score'] * 100 }}%">
                                            <span class="{{ $colors[$i % count($colors)]['text'] }} text-xs font-medium truncate">{{ $r['alternative_name'] }}</span>
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                        
                        <!-- Canvas for Chart.js -->
                        <canvas id="scoreChart" width="400" height="200"></canvas>
                    </div>
                    
                    <!-- Radar Chart -->
                    <div class="bg-white rounded-lg shadow-md p-6">
                        <h3 class="text-lg font-medium text-gray-900 mb-4">Distribusi Peringkat</h3>
                        
                        <!-- CSS-based fallback visualization for rank distribution -->
                        <div class="mb-6">
                            <div class="flex flex-wrap justify-center gap-4 mb-4">
                                @foreach($results as $i => $r)
                                    <div class="flex flex-col items-center">
                                        <div class="w-16 h-16 rounded-full flex items-center justify-center {{ $colors[$i % count($colors)]['bg'] }} mb-2">
                                            <span class="text-white text-lg font-bold">#{{ $i + 1 }}</span>
                                        </div>
                                        <span class="text-xs text-center font-medium text-gray-700 max-w-[80px] truncate" title="{{ $r['alternative_name'] }}">
                                            {{ $r['alternative_name'] }}
                                        </span>
                                        <span class="text-xs font-bold">
                                            {{ number_format($r['score'] * 100, 2) }}%
                                        </span>
                                    </div>
                                @endforeach
                            </div>
                            
                            <div class="mt-4 pt-4 border-t border-gray-200">
                                <div class="text-sm font-medium text-gray-700 mb-2">Distribusi Skor</div>
                                <div class="h-8 w-full bg-gray-200 rounded-full overflow-hidden flex">
                                    @php
                                        $totalScore = array_sum(array_column($results, 'score'));
                                        $currentPosition = 0;
                                    @endphp
                                    
                                    @foreach($results as $i => $r)
                                        @php
                                            $percentage = ($r['score'] / $totalScore) * 100;
                                            $width = $percentage;
                                        @endphp
                                        <div class="{{ $colors[$i % count($colors)]['bg'] }}" style="width: {{ $width }}%"></div>
                                    @endforeach
                                </div>
                                <div class="flex justify-between mt-1">
                                    <span class="text-xs text-gray-500">Peringkat Terendah</span>
                                    <span class="text-xs text-gray-500">Peringkat Tertinggi</span>
                                </div>
                            </div>
                        </div>
                        
                        <!-- Canvas for Chart.js -->
                        <canvas id="rankChart" width="400" height="200"></canvas>
                    </div>
                </div>

                <!-- Results Table -->
                <div class="bg-white rounded-lg shadow-md overflow-hidden">
                    <div class="p-6 border-b border-gray-200">
                        <h3 class="text-lg font-medium text-gray-900">Tabel Hasil Perhitungan</h3>
                        <p class="text-gray-500 text-sm mt-1">Peringkat alternatif berdasarkan skor akhir</p>
                    </div>
                    
                    <div class="overflow-x-auto">
                        <table class="w-full table-auto">
                            <thead>
                                <tr class="bg-gray-50 text-left">
                                    <th class="px-6 py-3 text-xs font-medium text-gray-500 uppercase tracking-wider">Peringkat</th>
                                    <th class="px-6 py-3 text-xs font-medium text-gray-500 uppercase tracking-wider">Alternatif</th>
                                    <th class="px-6 py-3 text-xs font-medium text-gray-500 uppercase tracking-wider text-right">Skor Akhir</th>
                                    <th class="px-6 py-3 text-xs font-medium text-gray-500 uppercase tracking-wider text-right">Persentase</th>
                                </tr>
                            </thead>
                            <tbody class="bg-white divide-y divide-gray-200">
                                @foreach($results as $i => $r)
                                    <tr class="hover:bg-gray-50 transition-colors duration-150 ease-in-out {{ $i === 0 ? 'bg-blue-50' : '' }}">
                                        <td class="px-6 py-4 whitespace-nowrap">
                                            @if($i === 0)
                                                <span class="inline-flex items-center justify-center w-6 h-6 bg-blue-600 text-white text-xs font-bold rounded-full">
                                                    {{ $i + 1 }}
                                                </span>
                                            @elseif($i === 1)
                                                <span class="inline-flex items-center justify-center w-6 h-6 bg-gray-600 text-white text-xs font-bold rounded-full">
                                                    {{ $i + 1 }}
                                                </span>
                                            @elseif($i === 2)
                                                <span class="inline-flex items-center justify-center w-6 h-6 bg-yellow-600 text-white text-xs font-bold rounded-full">
                                                    {{ $i + 1 }}
                                                </span>
                                            @else
                                                <span class="inline-flex items-center justify-center w-6 h-6 bg-gray-200 text-gray-700 text-xs font-bold rounded-full">
                                                    {{ $i + 1 }}
                                                </span>
                                            @endif
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap">
                                            <div class="flex items-center">
                                                <div class="ml-0">
                                                    <div class="text-sm font-medium text-gray-900">
                                                        {{ $r['alternative_name'] }}
                                                    </div>
                                                    @if($i === 0)
                                                        <div class="text-xs text-blue-600">
                                                            Alternatif Terbaik
                                                        </div>
                                                    @endif
                                                </div>
                                            </div>
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap text-right">
                                            <div class="text-sm font-medium text-gray-900">{{ number_format($r['score'], 4) }}</div>
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap text-right">
                                            <div class="w-full bg-gray-200 rounded-full h-2.5 mb-1 max-w-[150px] ml-auto">
                                                <div class="bg-blue-600 h-2.5 rounded-full" style="width: {{ $r['score'] * 100 }}%"></div>
                                            </div>
                                            <div class="text-sm font-medium text-gray-900">{{ number_format($r['score'] * 100, 2) }}%</div>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>

                <!-- Methodology Section -->
                <div class="mt-8 bg-white rounded-lg shadow-md p-6">
                    <h3 class="text-lg font-medium text-gray-900 mb-2">Tentang Metode ARAS</h3>
                    <p class="text-gray-600 text-sm">
                        Metode ARAS (Additive Ratio Assessment) adalah metode pengambilan keputusan multi-kriteria yang membandingkan 
                        nilai utilitas alternatif dengan nilai utilitas alternatif ideal. Metode ini menggunakan normalisasi dan pembobotan 
                        untuk menentukan peringkat alternatif berdasarkan kriteria yang telah ditentukan.
                    </p>
                    
                    <div class="mt-4 grid grid-cols-1 md:grid-cols-3 gap-4">
                        <div class="bg-gray-50 p-4 rounded-lg">
                            <h4 class="text-sm font-medium text-gray-900 mb-2">Langkah 1: Matriks Keputusan</h4>
                            <p class="text-xs text-gray-600">
                                Membentuk matriks keputusan dengan nilai alternatif untuk setiap kriteria, termasuk alternatif ideal.
                            </p>
                        </div>
                        <div class="bg-gray-50 p-4 rounded-lg">
                            <h4 class="text-sm font-medium text-gray-900 mb-2">Langkah 2: Normalisasi</h4>
                            <p class="text-xs text-gray-600">
                                Menormalisasi nilai-nilai dalam matriks keputusan berdasarkan jenis kriteria (benefit atau cost).
                            </p>
                        </div>
                        <div class="bg-gray-50 p-4 rounded-lg">
                            <h4 class="text-sm font-medium text-gray-900 mb-2">Langkah 3: Pembobotan</h4>
                            <p class="text-xs text-gray-600">
                                Mengalikan nilai ternormalisasi dengan bobot kriteria untuk mendapatkan matriks ternormalisasi terbobot.
                            </p>
                        </div>
                    </div>
                </div>
            @endif
        </div>

        @push('scripts')
        <!-- Include Chart.js directly from CDN -->
        <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
        <script>
            document.addEventListener('DOMContentLoaded', function() {
                @if(isset($results) && count($results) > 0)
                try {
                    console.log('Initializing charts...');
                    
                    // Prepare data for charts
                    const labels = [
                        @foreach($results as $r)
                            "{{ $r['alternative_name'] }}",
                        @endforeach
                    ];
                    
                    const scores = [
                        @foreach($results as $r)
                            {{ number_format($r['score'] * 100, 2, '.', '') }},
                        @endforeach
                    ];
                    
                    // Generate contrasting colors
                    const backgroundColors = [
                        '#3b82f6', // blue
                        '#8b5cf6', // purple
                        '#10b981', // green
                        '#ef4444', // red
                        '#f59e0b', // yellow
                        '#6366f1', // indigo
                        '#ec4899', // pink
                        '#14b8a6', // teal
                        '#f97316', // orange
                        '#06b6d4'  // cyan
                    ];
                    
                    // Score Chart (Horizontal Bar Chart)
                    const scoreCtx = document.getElementById('scoreChart');
                    if (scoreCtx) {
                        new Chart(scoreCtx, {
                            type: 'bar',
                            data: {
                                labels: labels,
                                datasets: [{
                                    label: 'Skor (%)',
                                    data: scores,
                                    backgroundColor: backgroundColors.slice(0, labels.length),
                                    borderWidth: 1
                                }]
                            },
                            options: {
                                indexAxis: 'y',  // Horizontal bar chart
                                responsive: true,
                                plugins: {
                                    legend: {
                                        display: false
                                    },
                                    tooltip: {
                                        callbacks: {
                                            label: function(context) {
                                                return context.raw + '%';
                                            }
                                        }
                                    }
                                },
                                scales: {
                                    x: {
                                        beginAtZero: true,
                                        title: {
                                            display: true,
                                            text: 'Skor (%)'
                                        }
                                    }
                                }
                            }
                        });
                        console.log('Score chart rendered successfully');
                    }
                    
                    // Rank Chart (Polar Area Chart)
                    const rankCtx = document.getElementById('rankChart');
                    if (rankCtx) {
                        new Chart(rankCtx, {
                            type: 'polarArea',
                            data: {
                                labels: labels,
                                datasets: [{
                                    label: 'Skor',
                                    data: scores,
                                    backgroundColor: backgroundColors.slice(0, labels.length),
                                    borderWidth: 1
                                }]
                            },
                            options: {
                                responsive: true,
                                plugins: {
                                    legend: {
                                        position: 'bottom',
                                        labels: {
                                            boxWidth: 12,
                                            font: {
                                                size: 10
                                            }
                                        }
                                    },
                                    tooltip: {
                                        callbacks: {
                                            label: function(context) {
                                                return context.label + ': ' + context.raw + '%';
                                            }
                                        }
                                    }
                                }
                            }
                        });
                        console.log('Rank chart rendered successfully');
                    }
                } catch (error) {
                    console.error('Error rendering charts:', error);
                    // Charts failed to render, but we have CSS fallbacks
                }
                
                // Print functionality
                document.getElementById('print-button').addEventListener('click', function() {
                    window.print();
                }); 
                
                // Export functionality
            document.getElementById('export-button').addEventListener('click', function () {
        // Tambahkan BOM untuk mendukung Excel
        const BOM = '\uFEFF';

        let csvContent = BOM + "Peringkat,Alternatif,Skor,Persentase\n";

        @foreach($results as $i => $r)
            csvContent += "{{ $i + 1 }},{{ $r['alternative_name'] }},{{ $r['score'] }},{{ number_format($r['score'] * 100, 2) }}%\n";
        @endforeach

        const blob = new Blob([csvContent], { type: 'text/csv;charset=utf-8;' });
        const link = document.createElement("a");
        const url = URL.createObjectURL(blob);
        link.setAttribute("href", url);
        link.setAttribute("download", "hasil_perhitungan_aras.csv");
        link.style.visibility = 'hidden';
        document.body.appendChild(link);
        link.click();
        document.body.removeChild(link);
    });

                @endif
            });
        </script>

        <style>
            @media print {
                body * {
                    visibility: hidden;
                }
                .max-w-6xl, .max-w-6xl * {
                    visibility: visible;
                }
                .max-w-6xl {
                    position: absolute;
                    left: 0;
                    top: 0;
                    width: 100%;
                }
                #print-button, #export-button, #scoreChart, #rankChart {
                    display: none;
                }
            }

            /* Dynamic color classes for error types */
            .bg-orange-50, .border-orange-200, .text-orange-600, .bg-orange-600, .hover\:bg-orange-700:hover,
            .bg-orange-100, .text-orange-800, .text-orange-700, .text-orange-400, .focus\:ring-orange-500:focus { }

            .bg-blue-50, .border-blue-200, .text-blue-600, .bg-blue-600, .hover\:bg-blue-700:hover,
            .bg-blue-100, .text-blue-800, .text-blue-700, .text-blue-400, .text-blue-500, .focus\:ring-blue-500:focus { }

            .bg-yellow-50, .border-yellow-200, .text-yellow-600, .bg-yellow-600, .hover\:bg-yellow-700:hover,
            .bg-yellow-100, .text-yellow-800, .text-yellow-700, .text-yellow-400, .focus\:ring-yellow-500:focus { }

            .bg-red-50, .border-red-200, .text-red-600, .bg-red-600, .hover\:bg-red-700:hover,
            .bg-red-100, .text-red-800, .text-red-700, .text-red-400, .focus\:ring-red-500:focus { }
        </style>
        @endpush
        @endsection
