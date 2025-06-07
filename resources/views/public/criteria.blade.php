@extends('layouts.user')

@section('content')
  <div class="max-w-6xl mx-auto px-4 py-8">
    <div class="flex justify-between items-center mb-6">
    <div>
      <h1 class="text-3xl font-bold text-gray-800">Daftar Kriteria</h1>
      <p class="text-gray-600 mt-1">Kriteria yang digunakan dalam perhitungan ARAS</p>
    </div>

    <div class="flex items-center space-x-2">
      <div class="bg-blue-100 text-blue-800 text-xs font-medium px-2.5 py-1 rounded flex items-center">
      <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-1" fill="none" viewBox="0 0 24 24"
        stroke="currentColor">
        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
        d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
      </svg>
      Total: {{ $criterias->count() }} kriteria
      </div>
    </div>
    </div>

    @if($criterias->isEmpty())
    <div class="bg-yellow-50 border-l-4 border-yellow-400 p-4 mb-6">
    <div class="flex">
      <div class="flex-shrink-0">
      <svg class="h-5 w-5 text-yellow-400" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor">
      <path fill-rule="evenodd"
      d="M8.257 3.099c.765-1.36 2.722-1.36 3.486 0l5.58 9.92c.75 1.334-.213 2.98-1.742 2.98H4.42c-1.53 0-2.493-1.646-1.743-2.98l5.58-9.92zM11 13a1 1 0 11-2 0 1 1 0 012 0zm-1-8a1 1 0 00-1 1v3a1 1 0 002 0V6a1 1 0 00-1-1z"
      clip-rule="evenodd" />
      </svg>
      </div>
      <div class="ml-3">
      <p class="text-sm text-yellow-700">
      Belum ada data kriteria. Kriteria diperlukan untuk perhitungan ARAS.
      </p>
      </div>
    </div>
    </div>
    @else
    <div class="bg-white rounded-lg shadow-md overflow-hidden">
    <div class="overflow-x-auto">
      <table class="w-full table-auto">
      <thead>
      <tr class="bg-gradient-to-r from-blue-600 to-blue-500 text-white">
      <th class="px-6 py-3 text-left text-xs font-medium uppercase tracking-wider w-16">No</th>
      <th class="px-6 py-3 text-left text-xs font-medium uppercase tracking-wider">Nama Kriteria</th>
      <th class="px-6 py-3 text-left text-xs font-medium uppercase tracking-wider">Jenis</th>
      <th class="px-6 py-3 text-left text-xs font-medium uppercase tracking-wider">Bobot</th>
      <th class="px-6 py-3 text-left text-xs font-medium uppercase tracking-wider">Persentase</th>
      </tr>
      </thead>
      <tbody class="bg-white divide-y divide-gray-200">
      @foreach($criterias as $i => $c)
      <tr class="hover:bg-gray-50 transition-colors duration-150 ease-in-out">
      <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900 font-medium">
      {{ $i + 1 }}
      </td>
      <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
      <div class="font-medium">{{ $c->criteria }}</div>
      @if(isset($c->description) && !empty($c->description))
      <div class="text-xs text-gray-500 mt-1">{{ $c->description }}</div>
      @endif
      </td>
      <td class="px-6 py-4 whitespace-nowrap text-sm">
      @if(strtolower($c->attribute) == 'benefit')
      <span class="bg-green-100 text-green-800 text-xs font-medium px-2.5 py-0.5 rounded">
      Benefit
      </span>
      @else
      <span class="bg-red-100 text-red-800 text-xs font-medium px-2.5 py-0.5 rounded">
      Cost
      </span>
      @endif
      </td>
      <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900 font-medium">
      {{ $c->weight }}
      </td>
      <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
      <div class="flex items-center">
      <div class="w-full bg-gray-200 rounded-full h-2.5 mr-2">
      <div class="bg-blue-600 h-2.5 rounded-full" style="width: {{ $c->weight * 100 }}%"></div>
      </div>
      <span class="text-xs font-medium">{{ number_format($c->weight * 100, 0) }}%</span>
      </div>
      </td>
      </tr>
      @endforeach
      </tbody>
      <tfoot class="bg-gray-50">
      <tr>
      <td colspan="3" class="px-6 py-3 text-right text-sm font-medium text-gray-700">
        Total Bobot:
      </td>
      <td class="px-6 py-3 text-sm font-bold text-gray-900">
        {{ $criterias->sum('weight') }}
      </td>
      <td class="px-6 py-3 text-sm font-bold text-gray-900">
        {{ number_format($criterias->sum('weight') * 100, 0) }}%
      </td>
      </tr>
      </tfoot>
      </table>
    </div>
    </div>

    <div class="mt-8 grid grid-cols-1 md:grid-cols-2 gap-6">
    <!-- Weight Distribution Chart -->
    <div class="bg-white rounded-lg shadow-md p-6">
      <h3 class="text-lg font-medium text-gray-900 mb-4">Distribusi Bobot Kriteria</h3>

      <!-- Fallback static visualization that doesn't require JavaScript -->
      <div class="mb-4">
      @foreach($criterias as $c)
      <div class="mb-3">
      <div class="flex justify-between mb-1">
      <span class="text-sm font-medium text-gray-700">{{ $c->criteria }}</span>
      <span class="text-sm font-medium text-gray-700">{{ number_format($c->weight * 100, 0) }}%</span>
      </div>
      <div class="w-full bg-gray-200 rounded-full h-4">
      <div class="bg-blue-600 h-4 rounded-full" style="width: {{ $c->weight * 100 }}%"></div>
      </div>
      </div>
    @endforeach
      </div>

      <!-- Canvas for Chart.js -->
      <canvas id="weightChart" width="400" height="200"></canvas>
    </div>

    <!-- Criteria Information Card -->
    <div class="bg-white rounded-lg shadow-md p-6">
      <h3 class="text-lg font-medium text-gray-900 mb-4">Informasi Kriteria</h3>

      <div class="space-y-4">
      <div class="flex items-center">
      <div class="w-10 h-10 rounded-full bg-blue-100 flex items-center justify-center mr-3">
      <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-blue-600" fill="none" viewBox="0 0 24 24"
        stroke="currentColor">
        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
        d="M13 7h8m0 0v8m0-8l-8 8-4-4-6 6" />
      </svg>
      </div>
      <div>
      <p class="text-sm font-medium text-gray-900">Benefit</p>
      <p class="text-xs text-gray-500">Semakin tinggi nilai, semakin baik</p>
      </div>
      </div>

      <div class="flex items-center">
      <div class="w-10 h-10 rounded-full bg-red-100 flex items-center justify-center mr-3">
      <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-red-600" fill="none" viewBox="0 0 24 24"
        stroke="currentColor">
        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
        d="M13 17h8m0 0v-8m0 8l-8-8-4 4-6-6" />
      </svg>
      </div>
      <div>
      <p class="text-sm font-medium text-gray-900">Cost</p>
      <p class="text-xs text-gray-500">Semakin rendah nilai, semakin baik</p>
      </div>
      </div>

      <div class="border-t border-gray-200 pt-4 mt-4">
      <h4 class="text-sm font-medium text-gray-900 mb-2">Tentang Metode ARAS</h4>
      <p class="text-xs text-gray-600">
      Metode ARAS (Additive Ratio Assessment) adalah metode MCDM yang membandingkan nilai utilitas alternatif
      dengan nilai utilitas alternatif ideal. Bobot kriteria menentukan kontribusi setiap kriteria terhadap hasil
      akhir.
      </p>
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
    document.addEventListener('DOMContentLoaded', function () {
    // Get the canvas element
    const ctx = document.getElementById('weightChart');

    // Only proceed if we have the canvas and criteria data
    if (ctx && {{ $criterias->count() }} > 0) {
      // Create data arrays for the chart
      const labels = [
      @foreach($criterias as $c)
      "{{ $c->criteria }}",
    @endforeach
      ];

      const data = [
      @foreach($criterias as $c)
      {{ $c->weight * 100 }},
    @endforeach
      ];

      // Generate colors
      const backgroundColors = [
      '#3b82f6', '#60a5fa', '#93c5fd', '#bfdbfe', '#dbeafe', '#2563eb', '#1d4ed8'
      ];

      // Create the chart
      new Chart(ctx, {
      type: 'pie',
      data: {
      labels: labels,
      datasets: [{
      label: 'Bobot (%)',
      data: data,
      backgroundColor: backgroundColors.slice(0, labels.length),
      borderWidth: 1
      }]
      },
      options: {
      responsive: true,
      plugins: {
      legend: {
        position: 'bottom',
      },
      tooltip: {
        callbacks: {
        label: function (context) {
        return context.label + ': ' + context.raw + '%';
        }
        }
      }
      }
      }
      });
    }
    });
    </script>
  @endpush
@endsection