@extends('layouts.user')
@section('title','Hasil Perhitungan')

@section('content')
  <div class="max-w-4xl mx-auto bg-white p-6 rounded shadow">
    <h1 class="text-2xl font-bold mb-4">Hasil Perhitungan ARAS</h1>

    @if($message ?? null)
      <p class="text-red-600">{{ $message }}</p>
    @else
      <table class="w-full table-auto border-collapse">
        <thead class="bg-gray-200">
          <tr>
            <th class="border px-4 py-2">Alternatif</th>
            <th class="border px-4 py-2">Skor Akhir</th>
            <th class="border px-4 py-2">Ranking</th>
          </tr>
        </thead>
        <tbody>
          @foreach($results as $i => $r)
            <tr class="{{ $i%2?'bg-gray-100':'' }}">
              <td class="border px-4 py-2">{{ $r['alternative_name'] }}</td>
              <td class="border px-4 py-2">{{ $r['score'] }}</td>
              <td class="border px-4 py-2">{{ $i+1 }}</td>
            </tr>
          @endforeach
        </tbody>
      </table>
    @endif
  </div>
@endsection
