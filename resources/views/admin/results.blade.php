@extends('layouts.admin')
<x-layout>
  <x-sidebar>

@section('content')
<div class="container mx-auto py-8 px-4">
    <h1 class="text-3xl font-bold text-center mb-8">ARAS Method Calculation Results</h1>

    {{-- Winner Card --}}
    <div class="mb-8 bg-gradient-to-r from-violet-500 to-purple-600 text-white rounded-lg shadow-lg">
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
                        <p class="text-white/80">Top Alternative</p>
                    </div>
                </div>
                <div class="text-center md:text-right">
                    <div class="text-4xl font-bold">{{ number_format($winnerScore * 100, 2) }}%</div>
                    <p class="text-white/80">Preference Value</p>
                </div>
            </div>
        </div>
    </div>

    {{-- Ranking Chart --}}
    <div class="mb-8 bg-white dark:bg-gray-800 rounded-lg shadow-lg">
        <div class="p-4 border-b border-gray-200 dark:border-gray-700">
            <h2 class="text-xl font-bold">Ranking Visualization</h2>
            <p class="text-gray-500 dark:text-gray-400">Preference values (Ki) for all alternatives</p>
        </div>
        <div class="p-4">
            <div class="h-[300px] w-full" id="ranking-chart"></div>
        </div>
    </div>

    {{-- Calculation Tabs --}}
    <div class="bg-white dark:bg-gray-800 rounded-lg shadow-lg">
        <div class="border-b border-gray-200 dark:border-gray-700">
            <ul class="flex flex-wrap -mb-px text-sm font-medium text-center" id="calculation-tabs" role="tablist">
                <li class="mr-2" role="presentation">
                    <button class="inline-block p-4 border-b-2 rounded-t-lg active" id="results-tab" data-tabs-target="#results" type="button" role="tab" aria-controls="results" aria-selected="true">Final Results</button>
                </li>
                <li class="mr-2" role="presentation">
                    <button class="inline-block p-4 border-b-2 border-transparent rounded-t-lg hover:text-gray-600 hover:border-gray-300 dark:hover:text-gray-300" id="decision-tab" data-tabs-target="#decision" type="button" role="tab" aria-controls="decision" aria-selected="false">Decision Matrix</button>
                </li>
                <li class="mr-2" role="presentation">
                    <button class="inline-block p-4 border-b-2 border-transparent rounded-t-lg hover:text-gray-600 hover:border-gray-300 dark:hover:text-gray-300" id="normalized-tab" data-tabs-target="#normalized" type="button" role="tab" aria-controls="normalized" aria-selected="false">Normalized Matrix</button>
                </li>
                <li class="mr-2" role="presentation">
                    <button class="inline-block p-4 border-b-2 border-transparent rounded-t-lg hover:text-gray-600 hover:border-gray-300 dark:hover:text-gray-300" id="weighted-tab" data-tabs-target="#weighted" type="button" role="tab" aria-controls="weighted" aria-selected="false">Weighted Matrix</button>
                </li>
                <li role="presentation">
                    <button class="inline-block p-4 border-b-2 border-transparent rounded-t-lg hover:text-gray-600 hover:border-gray-300 dark:hover:text-gray-300" id="s-values-tab" data-tabs-target="#s-values" type="button" role="tab" aria-controls="s-values" aria-selected="false">S Values</button>
                </li>
            </ul>
        </div>
        
        <div id="calculation-content">

             {{-- Final Results Tab --}}
            <div id="results" role="tabpanel" aria-labelledby="results-tab"
                 class="p-4 rounded-lg bg-gray-50 dark:bg-gray-800">
                <div class="overflow-x-auto">
                    <table class="w-full text-sm text-left text-gray-500 dark:text-gray-400">
                        <thead class="text-xs text-gray-700 uppercase bg-gray-100 dark:bg-gray-700 dark:text-gray-400">
                            <tr>
                                <th class="px-6 py-3 rounded-l-lg">Rank</th>
                                <th class="px-6 py-3">Alternative</th>
                                <th class="px-6 py-3">Ki Value</th>
                                <th class="px-6 py-3 rounded-r-lg">Percentage</th>
                            </tr>
                        </thead>
                        <tbody>
                            @php
                                $sortedK = collect($K)->sortByDesc(fn($v, $k) => $v);
                                $rank = 1;
                            @endphp
                            @foreach($sortedK as $id => $value)
                                @if($id !== 0)
                                <tr class="bg-white border-b dark:bg-gray-800 dark:border-gray-700
                                           hover:bg-gray-100 dark:hover:bg-gray-700
                                           {{ $rank === 1 ? 'bg-purple-50 dark:bg-purple-900/20' : '' }}">
                                    <td class="px-6 py-4">
                                        <span class="{{ $rank === 1 ? 'bg-purple-600 text-white' : 'bg-gray-200 text-gray-800 dark:bg-gray-700 dark:text-gray-300' }} text-xs font-medium px-2.5 py-0.5 rounded">
                                            #{{ $rank }}
                                        </span>
                                    </td>
                                    <td class="px-6 py-4 font-medium text-gray-900 dark:text-white">
                                        {{ $alternatif[$id] }}
                                        @if($rank === 1)
                                            <span class="bg-gray-100 text-gray-800 dark:bg-gray-700 dark:text-gray-300 text-xs font-medium ml-2 px-2.5 py-0.5 rounded">
                                                Winner
                                            </span>
                                        @endif
                                    </td>
                                    <td class="px-6 py-4 text-right">{{ number_format($value, 4) }}</td>
                                    <td class="px-6 py-4 text-right font-semibold">{{ number_format($value * 100, 2) }}%</td>
                                </tr>
                                @php $rank++; @endphp
                                @endif
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
            
            {{-- Decision Matrix Tab --}}
            <div class="hidden p-4 rounded-lg bg-gray-50 dark:bg-gray-800" id="decision" role="tabpanel" aria-labelledby="decision-tab">
                <div class="overflow-x-auto">
                    <table class="w-full text-sm text-left text-gray-500 dark:text-gray-400">
                        <thead class="text-xs text-gray-700 uppercase bg-gray-100 dark:bg-gray-700 dark:text-gray-400">
                            <tr>
                                <th scope="col" class="px-6 py-3 rounded-l-lg">Alternative</th>
                                @foreach($criteria as $c)
                                    <th scope="col" class="px-6 py-3 text-right">{{ $c->criteria }}</th>
                                @endforeach
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($X as $i => $row)
                                <tr class="bg-white border-b dark:bg-gray-800 dark:border-gray-700 hover:bg-gray-50 dark:hover:bg-gray-700 {{ $i === 0 ? 'bg-amber-50 dark:bg-amber-900/20' : '' }}">
                                    <td class="px-6 py-4 font-medium text-gray-900 dark:text-white">
                                        {{ $i === 0 ? 'Ideal (X₀)' : $alternatif[$i] }}
                                        @if($i === 0)
                                            <span class="bg-gray-100 text-gray-800 dark:bg-gray-700 dark:text-gray-300 text-xs font-medium ml-2 px-2.5 py-0.5 rounded">
                                                Ideal
                                            </span>
                                        @endif
                                    </td>
                                    @foreach($criteria as $c)
                                        <td class="px-6 py-4 text-right">{{ number_format($X[$i][$c->id_criteria], 4) }}</td>
                                    @endforeach
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
            
            {{-- Normalized Matrix Tab --}}
            <div class="hidden p-4 rounded-lg bg-gray-50 dark:bg-gray-800" id="normalized" role="tabpanel" aria-labelledby="normalized-tab">
                <div class="overflow-x-auto">
                    <table class="w-full text-sm text-left text-gray-500 dark:text-gray-400">
                        <thead class="text-xs text-gray-700 uppercase bg-gray-100 dark:bg-gray-700 dark:text-gray-400">
                            <tr>
                                <th scope="col" class="px-6 py-3 rounded-l-lg">Alternative</th>
                                @foreach($criteria as $c)
                                    <th scope="col" class="px-6 py-3 text-right">{{ $c->criteria }}</th>
                                @endforeach
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($R as $i => $row)
                                <tr class="bg-white border-b dark:bg-gray-800 dark:border-gray-700 hover:bg-gray-50 dark:hover:bg-gray-700 {{ $i === 0 ? 'bg-amber-50 dark:bg-amber-900/20' : '' }}">
                                    <td class="px-6 py-4 font-medium text-gray-900 dark:text-white">
                                        {{ $i === 0 ? 'Ideal (X₀)' : $alternatif[$i] }}
                                        @if($i === 0)
                                            <span class="bg-gray-100 text-gray-800 dark:bg-gray-700 dark:text-gray-300 text-xs font-medium ml-2 px-2.5 py-0.5 rounded">
                                                Ideal
                                            </span>
                                        @endif
                                    </td>
                                    @foreach($criteria as $c)
                                        <td class="px-6 py-4 text-right">{{ number_format($R[$i][$c->id_criteria], 4) }}</td>
                                    @endforeach
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
            
            {{-- Weighted Matrix Tab --}}
            <div class="hidden p-4 rounded-lg bg-gray-50 dark:bg-gray-800" id="weighted" role="tabpanel" aria-labelledby="weighted-tab">
                <div class="overflow-x-auto">
                    <table class="w-full text-sm text-left text-gray-500 dark:text-gray-400">
                        <thead class="text-xs text-gray-700 uppercase bg-gray-100 dark:bg-gray-700 dark:text-gray-400">
                            <tr>
                                <th scope="col" class="px-6 py-3 rounded-l-lg">Alternative</th>
                                @foreach($criteria as $c)
                                    <th scope="col" class="px-6 py-3 text-right">{{ $c->criteria }}</th>
                                @endforeach
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($D as $i => $row)
                                <tr class="bg-white border-b dark:bg-gray-800 dark:border-gray-700 hover:bg-gray-50 dark:hover:bg-gray-700 {{ $i === 0 ? 'bg-amber-50 dark:bg-amber-900/20' : '' }}">
                                    <td class="px-6 py-4 font-medium text-gray-900 dark:text-white">
                                        {{ $i === 0 ? 'Ideal (X₀)' : $alternatif[$i] }}
                                        @if($i === 0)
                                            <span class="bg-gray-100 text-gray-800 dark:bg-gray-700 dark:text-gray-300 text-xs font-medium ml-2 px-2.5 py-0.5 rounded">
                                                Ideal
                                            </span>
                                        @endif
                                    </td>
                                    @foreach($criteria as $c)
                                        <td class="px-6 py-4 text-right">{{ number_format($D[$i][$c->id_criteria], 4) }}</td>
                                    @endforeach
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
            
            {{-- S Values Tab --}}
            <div class="hidden p-4 rounded-lg bg-gray-50 dark:bg-gray-800" id="s-values" role="tabpanel" aria-labelledby="s-values-tab">
                <div class="overflow-x-auto">
                    <table class="w-full text-sm text-left text-gray-500 dark:text-gray-400">
                        <thead class="text-xs text-gray-700 uppercase bg-gray-100 dark:bg-gray-700 dark:text-gray-400">
                            <tr>
                                <th scope="col" class="px-6 py-3 rounded-l-lg">Alternative</th>
                                <th scope="col" class="px-6 py-3 rounded-r-lg text-right">Si Value</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($S as $i => $si)
                                <tr class="bg-white border-b dark:bg-gray-800 dark:border-gray-700 hover:bg-gray-50 dark:hover:bg-gray-700 {{ $i === 0 ? 'bg-amber-50 dark:bg-amber-900/20' : '' }}">
                                    <td class="px-6 py-4 font-medium text-gray-900 dark:text-white">
                                        {{ $i === 0 ? 'Ideal (X₀)' : $alternatif[$i] }}
                                        @if($i === 0)
                                            <span class="bg-gray-100 text-gray-800 dark:bg-gray-700 dark:text-gray-300 text-xs font-medium ml-2 px-2.5 py-0.5 rounded">
                                                Ideal
                                            </span>
                                        @endif
                                    </td>
                                    <td class="px-6 py-4 text-right">{{ number_format($si, 4) }}</td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>

@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/apexcharts"></script>
<script>
    document.addEventListener('DOMContentLoaded', function() {
        // Tab functionality
        const tabs = document.querySelectorAll('[data-tabs-target]');
        const tabContents = document.querySelectorAll('[role="tabpanel"]');
        
        tabs.forEach(tab => {
            tab.addEventListener('click', () => {
                const target = document.querySelector(tab.dataset.tabsTarget);
                
                tabContents.forEach(tc => {
                    tc.classList.add('hidden');
                });
                
                tabs.forEach(t => {
                    t.classList.remove('active', 'border-blue-600', 'text-blue-600');
                    t.classList.add('border-transparent');
                });
                
                tab.classList.add('active', 'border-blue-600', 'text-blue-600');
                tab.classList.remove('border-transparent');
                target.classList.remove('hidden');
            });
        });
        
        // Prepare data for chart
        const chartData = [];
        @php
            $sortedForChart = collect($K)->sortByDesc(function ($item, $key) {
                return $item;
            })->take(10);
        @endphp
        
        @foreach($sortedForChart as $id => $value)
            @if($id !== 0) {{-- Skip the ideal solution --}}
                chartData.push({
                    x: '{{ $alternatif[$id] }}',
                    y: {{ number_format($value * 100, 2, '.', '') }}
                });
            @endif
        @endforeach
        
        // Initialize chart
       const options = {
        chart: {
          type: 'bar',
          height: 300,
          foreColor: '#EDF2F7', // white-ish text
          toolbar: { show: false }
        },
        series: [{ name: 'Preference Value (%)', data: chartData }],
        plotOptions: { bar: { horizontal: true, borderRadius: 4, dataLabels: { position: 'top' } } },
        dataLabels: {
          enabled: true,
          formatter: v => v.toFixed(2) + '%',
          offsetX: 30,
          style: { colors: ['#EDF2F7'], fontSize: '12px' }
        },
        xaxis: {
          categories: chartData.map(i => i.x),
          labels: { formatter: v => v.toFixed(2) + '%', style: { colors: ['#EDF2F7'] } },
          title: { text: 'Preference Value (%)', style: { color: '#EDF2F7' } }
        },
        yaxis: {
          labels: { style: { colors: ['#EDF2F7'] } },
          title: { text: 'Alternative', style: { color: '#EDF2F7' } }
        },
        tooltip: { theme: 'dark', y: { formatter: v => v.toFixed(2) + '%' } }
      };

      const chart = new ApexCharts(document.querySelector("#ranking-chart"), options);
      chart.render();
    });
</script>
@endpush
@endsection
  </x-sidebar>
</x-layout>