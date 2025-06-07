@extends('layouts.user')

@section('content')
<div class="max-w-6xl mx-auto px-4 py-8">
    <div class="flex justify-between items-center mb-6">
        <div>
            <h1 class="text-3xl font-bold text-gray-800">Daftar Alternatif</h1>
            <p class="text-gray-600 mt-1">Alternatif yang digunakan dalam perhitungan ARAS</p>
        </div>
        
        <div class="flex items-center space-x-2">
            <div class="bg-blue-100 text-blue-800 text-xs font-medium px-2.5 py-1 rounded flex items-center">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-1" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                </svg>
                Total: {{ $alternatives->count() }} alternatif
            </div>
        </div>
    </div>

    @if($alternatives->isEmpty())
        <div class="bg-yellow-50 border-l-4 border-yellow-400 p-4 mb-6">
            <div class="flex">
                <div class="flex-shrink-0">
                    <svg class="h-5 w-5 text-yellow-400" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor">
                        <path fill-rule="evenodd" d="M8.257 3.099c.765-1.36 2.722-1.36 3.486 0l5.58 9.92c.75 1.334-.213 2.98-1.742 2.98H4.42c-1.53 0-2.493-1.646-1.743-2.98l5.58-9.92zM11 13a1 1 0 11-2 0 1 1 0 012 0zm-1-8a1 1 0 00-1 1v3a1 1 0 002 0V6a1 1 0 00-1-1z" clip-rule="evenodd" />
                    </svg>
                </div>
                <div class="ml-3">
                    <p class="text-sm text-yellow-700">
                        Belum ada data alternatif. Alternatif diperlukan untuk perhitungan ARAS.
                    </p>
                </div>
            </div>
        </div>
    @else
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
            @foreach($alternatives as $i => $a)
                <div class="bg-white rounded-lg shadow-md overflow-hidden hover:shadow-lg transition-shadow duration-300">
                    <div class="bg-gradient-to-r from-blue-600 to-blue-500 px-4 py-2">
                        <div class="flex justify-between items-center">
                            <span class="text-white font-medium">Alternatif {{ $i + 1 }}</span>
                            <span class="bg-white text-blue-600 text-xs font-bold px-2 py-1 rounded-full">ID: {{ $a->id_alternative ?? $a->id }}</span>
                        </div>
                    </div>
                    <div class="p-5">
                        <h3 class="text-xl font-semibold text-gray-800 mb-2">{{ $a->name }}</h3>
                        
                        @if(isset($a->description) && !empty($a->description))
                            <p class="text-gray-600 text-sm mb-4">{{ $a->description }}</p>
                        @else
                        @endif
                        
                        <div class="flex items-center text-gray-500 text-sm">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-1" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
                            </svg>
                            <span>Ditambahkan: {{ isset($a->created_at) ? $a->created_at->format('d M Y') : 'N/A' }}</span>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>

        <div class="mt-8 grid grid-cols-1 md:grid-cols-2 gap-6">
            <!-- Alternatives Chart -->
            <div class="bg-white rounded-lg shadow-md p-6">
                <h3 class="text-lg font-medium text-gray-900 mb-4">Visualisasi Alternatif</h3>
                
                <!-- CSS-based visualization with contrasting colors -->
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
                    
                    @foreach($alternatives as $i => $a)
                        <div class="mb-3">
                            <div class="flex justify-between mb-1">
                                <span class="text-sm font-medium text-gray-700">{{ $a->name }}</span>
                                <span class="text-sm font-medium text-gray-700">Alternatif {{ $i + 1 }}</span>
                            </div>
                            <div class="w-full bg-gray-200 rounded-full h-8 flex items-center">
                                <div class="{{ $colors[$i % count($colors)]['bg'] }} h-8 rounded-full px-3 flex items-center" style="width: 100%">
                                    <span class="{{ $colors[$i % count($colors)]['text'] }} text-xs font-medium">{{ $a->name }}</span>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
                
                <!-- Canvas for Chart.js -->
                <canvas id="alternativesChart" width="400" height="200"></canvas>
            </div>

            <!-- Alternatives Information Card -->
            <div class="bg-white rounded-lg shadow-md p-6">
                <h3 class="text-lg font-medium text-gray-900 mb-4">Informasi Alternatif</h3>
                
                <div class="space-y-4">
                    <div class="flex items-start">
                        <div class="w-10 h-10 rounded-full bg-blue-100 flex items-center justify-center mr-3 mt-1">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-blue-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2" />
                            </svg>
                        </div>
                        <div>
                            <p class="text-sm font-medium text-gray-900">Tentang Alternatif</p>
                            <p class="text-xs text-gray-500">
                                Alternatif adalah pilihan-pilihan yang akan dievaluasi menggunakan metode ARAS. 
                                Setiap alternatif akan dinilai berdasarkan kriteria yang telah ditentukan.
                            </p>
                        </div>
                    </div>
                    
                    <div class="flex items-start">
                        <div class="w-10 h-10 rounded-full bg-green-100 flex items-center justify-center mr-3 mt-1">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-green-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                            </svg>
                        </div>
                        <div>
                            <p class="text-sm font-medium text-gray-900">Langkah Selanjutnya</p>
                            <p class="text-xs text-gray-500">
                                Setelah menentukan alternatif, langkah selanjutnya adalah melakukan evaluasi 
                                untuk setiap alternatif berdasarkan kriteria yang ada.
                            </p>
                        </div>
                    </div>
                    
                    <div class="border-t border-gray-200 pt-4 mt-4">
                        <h4 class="text-sm font-medium text-gray-900 mb-2">Statistik</h4>
                        <div class="grid grid-cols-2 gap-4">
                            <div class="bg-gray-50 p-3 rounded-lg">
                                <p class="text-xs text-gray-500">Total Alternatif</p>
                                <p class="text-lg font-bold text-gray-900">{{ $alternatives->count() }}</p>
                            </div>
                            <div class="bg-gray-50 p-3 rounded-lg">
                                <p class="text-xs text-gray-500">Status</p>
                                <p class="text-lg font-bold text-green-600">Siap Evaluasi</p>
                            </div>
                        </div>
                    </div>
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
        // Get the canvas element
        const ctx = document.getElementById('alternativesChart');
        
        // Only proceed if we have the canvas and alternatives data
        if (ctx && {{ $alternatives->count() }} > 0) {
            try {
                console.log('Initializing chart...');
                
                // Create data arrays for the chart
                const labels = [
                    @foreach($alternatives as $a)
                        "{{ $a->name }}",
                    @endforeach
                ];
                
                // All alternatives have equal value for the chart
                const data = Array({{ $alternatives->count() }}).fill(100);
                
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
                
                // Create the chart
                new Chart(ctx, {
                    type: 'bar',
                    data: {
                        labels: labels,
                        datasets: [{
                            label: 'Alternatif',
                            data: data,
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
                                        return context.label;
                                    }
                                }
                            }
                        },
                        scales: {
                            x: {
                                beginAtZero: true,
                                grid: {
                                    display: false
                                },
                                ticks: {
                                    display: false
                                }
                            }
                        }
                    }
                });
                
                console.log('Chart rendered successfully');
            } catch (error) {
                console.error('Error rendering chart:', error);
                
                // Chart rendering failed, but we already have the CSS fallback
                // so no additional fallback is needed here
            }
        }
    });
</script>
@endpush
@endsection 