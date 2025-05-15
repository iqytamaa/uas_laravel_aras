@extends('layouts.user')

@section('content')
  <div class="max-w-4xl mx-auto p-6 bg-white rounded shadow">
    <h1 class="text-3xl font-bold mb-4">Daftar Alternatif</h1>

    @if($alternatives->isEmpty())
      <p class="text-gray-600">Belum ada data alternatif.</p>
    @else
      <ul class="list-disc pl-5">
        @foreach($alternatives as $i => $a)
          <li class="mb-2">
            {{ $i + 1 }}. {{ $a->name }}
          </li>
        @endforeach
      </ul>
    @endif
  </div>
@endsection
