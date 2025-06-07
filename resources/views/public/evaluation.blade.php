@extends('layouts.user')
@section('title', 'Evaluasi Alternatif vs Kriteria')

@section('content')
<div class="max-w-6xl mx-auto px-4 py-8">
    <div class="flex justify-between items-center mb-6">
        <div>
            <h1 class="text-3xl font-bold text-gray-800">Evaluasi Alternatif vs Kriteria</h1>
            <p class="text-gray-600 mt-1">Masukkan nilai untuk setiap alternatif berdasarkan kriteria yang ada</p>
        </div>
        
        <div class="bg-blue-100 text-blue-800 text-xs font-medium px-2.5 py-1 rounded flex items-center">
            <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-1" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
            </svg>
            Total: {{ $alternatives->count() }} alternatif, {{ $criterias->count() }} kriteria
        </div>
    </div>

    <div class="bg-white rounded-lg shadow-md overflow-hidden">
        <div class="p-6 border-b border-gray-200">
            <div class="flex flex-col md:flex-row md:items-center justify-between">
                <div>
                    <h2 class="text-lg font-medium text-gray-900">Form Evaluasi</h2>
                    <p class="text-gray-500 text-sm mt-1">Masukkan nilai untuk setiap kombinasi alternatif dan kriteria</p>
                </div>
                
                <div class="mt-4 md:mt-0 flex space-x-2">
                    <button id="reset-form" type="button" class="flex items-center text-sm bg-gray-100 hover:bg-gray-200 text-gray-700 py-2 px-3 rounded-lg transition-colors">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-1" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15" />
                        </svg>
                        Reset
                    </button>
                    <button id="auto-fill" type="button" class="flex items-center text-sm bg-green-100 hover:bg-green-200 text-green-700 py-2 px-3 rounded-lg transition-colors">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-1" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
                        </svg>
                        Auto-fill
                    </button>
                </div>
            </div>
        </div>
        
        <form id="form-evaluation-public" action="{{ route('user.evaluation.submit') }}" method="POST">
            @csrf
            <div class="overflow-x-auto">
                <table class="w-full table-auto">
                    <thead>
                        <tr class="bg-gray-50 text-left">
                            <th class="px-6 py-3 text-xs font-medium text-gray-500 uppercase tracking-wider sticky left-0 bg-gray-50 z-10 border-b border-r border-gray-200">Alternatif</th>
                            @foreach($criterias as $crit)
                                <th class="px-6 py-3 text-xs font-medium text-gray-500 uppercase tracking-wider text-center border-b border-gray-200">
                                    <div>{{ $crit->criteria }}</div>
                                    @if(isset($crit->type))
                                        <div class="text-xs normal-case font-normal mt-1 px-2 py-0.5 rounded 
                                            {{ $crit->type == 'benefit' ? 'bg-green-100 text-green-800' : 'bg-red-100 text-red-800' }}">
                                            {{ $crit->type == 'benefit' ? 'Benefit' : 'Cost' }}
                                        </div>
                                    @endif
                                </th>
                            @endforeach
                        </tr>
                    </thead>
                    <tbody class="bg-white divide-y divide-gray-200">
                        @foreach($alternatives as $i => $alt)
                            <tr class="hover:bg-gray-50 transition-colors duration-150 ease-in-out">
                                <td class="px-6 py-4 whitespace-nowrap sticky left-0 bg-white z-10 border-r border-gray-200 {{ $i % 2 == 1 ? 'bg-gray-50' : '' }}">
                                    <div class="flex items-center">
                                        <div class="flex-shrink-0 h-8 w-8 flex items-center justify-center rounded-full bg-blue-100 text-blue-600">
                                            {{ $i + 1 }}
                                        </div>
                                        <div class="ml-4">
                                            <div class="text-sm font-medium text-gray-900">{{ $alt->name }}</div>
                                            @if(isset($alt->description) && !empty($alt->description))
                                                <div class="text-xs text-gray-500 max-w-xs truncate" title="{{ $alt->description }}">
                                                    {{ $alt->description }}
                                                </div>
                                            @endif
                                        </div>
                                    </div>
                                </td>
                                @foreach($criterias as $crit)
                                    @php
                                        $ev = $evaluations
                                            ->where('id_alternative', $alt->id_alternative)
                                            ->where('id_criteria', $crit->id_criteria)
                                            ->first();
                                    @endphp
                                    <td class="px-6 py-4 whitespace-nowrap text-center {{ $i % 2 == 1 ? 'bg-gray-50' : '' }}">
                                        <div class="relative">
                                            <input 
                                                type="number" 
                                                step="any"
                                                name="evaluations[{{ $alt->id_alternative }}][{{ $crit->id_criteria }}]"
                                                value="{{ $ev?->value ?? '' }}" 
                                                data-original-value="{{ $ev?->value ?? '' }}"
                                                required 
                                                min="0"
                                                class="w-24 p-2 border border-gray-300 rounded-md text-center focus:ring-blue-500 focus:border-blue-500 transition-colors" 
                                                placeholder="Nilai"
                                            />
                                            @if(isset($crit->weight))
                                                <div class="absolute -top-1 -right-1 bg-blue-600 text-white text-xs rounded-full w-5 h-5 flex items-center justify-center" title="Bobot: {{ $crit->weight }}">
                                                    {{ $crit->weight }}
                                                </div>
                                            @endif
                                        </div>
                                    </td>
                                @endforeach
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
            
            <div class="px-6 py-4 bg-gray-50 border-t border-gray-200">
                <div class="flex flex-col sm:flex-row justify-between items-center">
                    <div class="text-sm text-gray-500 mb-4 sm:mb-0">
                        <span class="inline-flex items-center">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-1 text-yellow-500" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                            </svg>
                            Pastikan semua nilai sudah diisi dengan benar sebelum mengirim
                        </span>
                    </div>
                    
                    <div class="flex space-x-3">
                        <button type="button" id="cancel-button" class="bg-gray-100 hover:bg-gray-200 text-gray-700 px-4 py-2 rounded-lg transition-colors">
                            Batal
                        </button>
                        <button type="submit" class="bg-blue-600 hover:bg-blue-700 text-white px-6 py-2 rounded-lg transition-colors flex items-center">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
                            </svg>
                            Submit Evaluasi
                        </button>
                    </div>
                </div>
            </div>
        </form>
    </div>
    
    <!-- Information Cards -->
    <div class="mt-8 grid grid-cols-1 md:grid-cols-2 gap-6">
        <!-- Evaluation Guide -->
        <div class="bg-white rounded-lg shadow-md p-6">
            <h3 class="text-lg font-medium text-gray-900 mb-4">Panduan Evaluasi</h3>
            
            <div class="space-y-4">
                <div class="flex items-start">
                    <div class="w-10 h-10 rounded-full bg-blue-100 flex items-center justify-center mr-3 mt-1">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-blue-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                        </svg>
                    </div>
                    <div>
                        <p class="text-sm font-medium text-gray-900">Tentang Evaluasi</p>
                        <p class="text-xs text-gray-500">
                            Evaluasi adalah proses memberikan nilai pada setiap alternatif berdasarkan kriteria yang telah ditentukan.
                            Nilai-nilai ini akan digunakan dalam perhitungan metode ARAS.
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
                        <p class="text-sm font-medium text-gray-900">Kriteria Benefit</p>
                        <p class="text-xs text-gray-500">
                            Kriteria benefit adalah kriteria yang semakin tinggi nilainya semakin baik.
                            Contoh: nilai ujian, kehadiran, dll.
                        </p>
                    </div>
                </div>
                
                <div class="flex items-start">
                    <div class="w-10 h-10 rounded-full bg-red-100 flex items-center justify-center mr-3 mt-1">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-red-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12H9m12 0a9 9 0 11-18 0 9 9 0 0118 0z" />
                        </svg>
                    </div>
                    <div>
                        <p class="text-sm font-medium text-gray-900">Kriteria Cost</p>
                        <p class="text-xs text-gray-500">
                            Kriteria cost adalah kriteria yang semakin rendah nilainya semakin baik.
                            Contoh: biaya, waktu pengerjaan, dll.
                        </p>
                    </div>
                </div>
            </div>
        </div>
        
        <!-- Tips Card -->
        <div class="bg-white rounded-lg shadow-md p-6">
            <h3 class="text-lg font-medium text-gray-900 mb-4">Tips Pengisian</h3>
            
            <ul class="space-y-2 text-sm text-gray-600">
                <li class="flex items-start">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-blue-500 mr-2 flex-shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
                    </svg>
                    <span>Pastikan semua nilai diisi dengan benar sesuai dengan skala penilaian yang digunakan.</span>
                </li>
                <li class="flex items-start">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-blue-500 mr-2 flex-shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
                    </svg>
                    <span>Gunakan tombol "Auto-fill" untuk mengisi nilai secara otomatis jika diperlukan.</span>
                </li>
                <li class="flex items-start">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-blue-500 mr-2 flex-shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
                    </svg>
                    <span>Nilai yang dimasukkan akan disimpan dan digunakan dalam perhitungan ARAS.</span>
                </li>
                <li class="flex items-start">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-blue-500 mr-2 flex-shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
                    </svg>
                    <span>Setelah mengirim evaluasi, Anda dapat melihat hasil perhitungan di halaman Hasil.</span>
                </li>
            </ul>
            
            <div class="mt-4 pt-4 border-t border-gray-200">
                <div class="flex items-center justify-between">
                    <span class="text-sm font-medium text-gray-900">Progress Pengisian</span>
                    <span class="text-sm font-medium text-blue-600" id="progress-text">0%</span>
                </div>
                <div class="w-full bg-gray-200 rounded-full h-2.5 mt-2">
                    <div class="bg-blue-600 h-2.5 rounded-full" id="progress-bar" style="width: 0%"></div>
                </div>
            </div>
        </div>
    </div>
</div>

@endsection

@section('scripts')
<!-- SweetAlert2 CDN -->
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>
document.addEventListener('DOMContentLoaded', function() {
    const form = document.getElementById('form-evaluation-public');
    const inputs = form.querySelectorAll('input[type="number"]');
    const progressBar = document.getElementById('progress-bar');
    const progressText = document.getElementById('progress-text');
    const resetButton = document.getElementById('reset-form');
    const autoFillButton = document.getElementById('auto-fill');
    const cancelButton = document.getElementById('cancel-button');
    
    // Store original values
    const originalValues = {};
    inputs.forEach(input => {
        const name = input.getAttribute('name');
        originalValues[name] = input.getAttribute('data-original-value');
    });
    
    // Update progress bar
    function updateProgress() {
        const totalInputs = inputs.length;
        let filledInputs = 0;
        
        inputs.forEach(input => {
            if (input.value.trim() !== '') {
                filledInputs++;
            }
        });
        
        const progressPercentage = totalInputs > 0 ? Math.round((filledInputs / totalInputs) * 100) : 0;
        progressBar.style.width = progressPercentage + '%';
        progressText.textContent = progressPercentage + '%';
        
        return progressPercentage;
    }
    
    // Initialize progress
    updateProgress();
    
    // Update progress when inputs change
    inputs.forEach(input => {
        input.addEventListener('input', updateProgress);
    });
    
    // Reset form
    resetButton.addEventListener('click', function() {
        Swal.fire({
            title: 'Reset Form?',
            text: 'Semua nilai yang telah diisi akan dihapus.',
            icon: 'warning',
            showCancelButton: true,
            confirmButtonText: 'Ya, reset',
            cancelButtonText: 'Batal',
        }).then((result) => {
            if (result.isConfirmed) {
                inputs.forEach(input => {
                    input.value = '';
                });
                updateProgress();
                Swal.fire('Reset', 'Form telah direset.', 'success');
            }
        });
    });
    
    // Auto-fill form with random values
    autoFillButton.addEventListener('click', function() {
        Swal.fire({
            title: 'Auto-fill Form?',
            text: 'Form akan diisi dengan nilai acak antara 0-100.',
            icon: 'question',
            showCancelButton: true,
            confirmButtonText: 'Ya, isi',
            cancelButtonText: 'Batal',
        }).then((result) => {
            if (result.isConfirmed) {
                inputs.forEach(input => {
                    // Generate random number between 0-100 with 1 decimal place
                    const randomValue = (Math.random() * 100).toFixed(1);
                    input.value = randomValue;
                });
                updateProgress();
                Swal.fire('Auto-fill', 'Form telah diisi dengan nilai acak.', 'success');
            }
        });
    });
    
    // Cancel button - revert to original values
    cancelButton.addEventListener('click', function() {
        // Check if any changes were made
        let hasChanges = false;
        inputs.forEach(input => {
            const name = input.getAttribute('name');
            if (input.value !== originalValues[name]) {
                hasChanges = true;
            }
        });
        
        if (hasChanges) {
            Swal.fire({
                title: 'Batalkan Perubahan?',
                text: 'Semua perubahan akan dibatalkan dan nilai akan dikembalikan ke nilai awal.',
                icon: 'question',
                showCancelButton: true,
                confirmButtonText: 'Ya, batalkan perubahan',
                cancelButtonText: 'Tidak',
            }).then((result) => {
                if (result.isConfirmed) {
                    // Revert to original values
                    inputs.forEach(input => {
                        const name = input.getAttribute('name');
                        input.value = originalValues[name];
                    });
                    updateProgress();
                    Swal.fire('Dibatalkan', 'Perubahan telah dibatalkan.', 'info');
                }
            });
        } else {
            Swal.fire({
                title: 'Tidak Ada Perubahan',
                text: 'Tidak ada perubahan yang perlu dibatalkan.',
                icon: 'info',
                confirmButtonText: 'OK',
            });
        }
    });
    
    // Form submission
    form.addEventListener('submit', function(e) {
        e.preventDefault();
        
        // Check HTML5 validity
        if (!form.checkValidity()) {
            form.reportValidity();
            return;
        }
        
        // Check if all inputs are filled
        const progress = updateProgress();
        if (progress < 100) {
            Swal.fire({
                title: 'Form Belum Lengkap',
                text: 'Beberapa nilai belum diisi. Lanjutkan pengiriman?',
                icon: 'warning',
                showCancelButton: true,
                confirmButtonText: 'Ya, kirim',
                cancelButtonText: 'Batal',
            }).then((result) => {
                if (result.isConfirmed) {
                    submitForm();
                }
            });
        } else {
            submitForm();
        }
    });
    
    function submitForm() {
        Swal.fire({
            title: 'Kirim Evaluasi?',
            text: 'Pastikan nilai yang Anda masukkan sudah benar.',
            icon: 'question',
            showCancelButton: true,
            confirmButtonText: 'Ya, kirim',
            cancelButtonText: 'Batal',
        }).then((result) => {
            if (result.isConfirmed) {
                // Show loading state
                Swal.fire({
                    title: 'Mengirim...',
                    text: 'Mohon tunggu sebentar.',
                    allowOutsideClick: false,
                    didOpen: () => {
                        Swal.showLoading();
                    }
                });
                
                // Submit the form
                form.submit();
            }
        });
    }
    
    // Highlight row on hover
    const tableRows = document.querySelectorAll('tbody tr');
    tableRows.forEach(row => {
        row.addEventListener('mouseenter', function() {
            this.classList.add('bg-blue-50');
        });
        row.addEventListener('mouseleave', function() {
            this.classList.remove('bg-blue-50');
        });
    });
});
</script>

<style>
    /* Make the first column sticky for better mobile experience */
    @media (max-width: 768px) {
        .sticky {
            position: sticky;
            background-color: white;
            z-index: 10;
        }
    }
    
    /* Highlight active input */
    input:focus {
        box-shadow: 0 0 0 3px rgba(59, 130, 246, 0.3);
    }
    
    /* Improve number input appearance */
    input[type="number"] {
        -moz-appearance: textfield;
    }
    
    input[type="number"]::-webkit-outer-spin-button,
    input[type="number"]::-webkit-inner-spin-button {
        -webkit-appearance: none;
        margin: 0;
    }
</style>
@endsection