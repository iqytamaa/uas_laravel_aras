@extends('layouts.user')

@section('content')
  <div class="max-w-4xl mx-auto p-6 bg-white rounded shadow">
    <h1 class="text-3xl font-bold mb-4">Daftar Kriteria</h1>

    @if($criterias->isEmpty())
      <p class="text-gray-600">Belum ada data kriteria.</p>
    @else
      <table class="w-full table-auto border-collapse">
        <thead>
          <tr class="bg-gray-200">
            <th class="border px-4 py-2">No</th>
            <th class="border px-4 py-2">Nama Kriteria</th>
            <th class="border px-4 py-2">Jenis</th>
            <th class="border px-4 py-2">Bobot</th>
          </tr>
        </thead>
        <tbody>
          @foreach($criterias as $i => $c)
            <tr class="{{ $i % 2 ? 'bg-gray-50' : '' }}">
              <td class="border px-4 py-2">{{ $i + 1 }}</td>
              <td class="border px-4 py-2">{{ $c->criteria }}</td>
              <td class="border px-4 py-2">{{ ucfirst($c->attribute) }}</td>
              <td class="border px-4 py-2">{{ $c->weight }}</td>
            </tr>
          @endforeach
        </tbody>
      </table>
    @endif
  </div>
@endsection
